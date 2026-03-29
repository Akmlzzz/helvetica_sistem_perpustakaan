<?php

namespace App\Http\Controllers\Anggota;

use App\Models\PengajuanBuku;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnggotaController extends Controller
{
    /**
     * Katalog Buku - hanya card, bisa diklik
     * Support AJAX search/filter (parameter ajax=1)
     */
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'series']);

        $isFilteringSeries = $request->filled('series') && $request->series !== 'all';

        if ($isFilteringSeries) {
            // Jika memfilter berdasarkan series tertentu, tampilkan semua BUKU dalam series tersebut 
            $query->where('id_series', $request->series);
        } else {
            // Default di halaman utama: kelompokkan buku-buku dari series yang sama menjadi 1 perwakilan
            $query->whereIn('id_buku', function ($q) {
                $q->selectRaw('MIN(id_buku)')
                    ->from('buku')
                    ->groupByRaw('IFNULL(id_series, id_buku)');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', '%' . $search . '%')
                    ->orWhere('penulis', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhere('sinopsis', 'like', '%' . $search . '%')
                    ->orWhereHas('series', function ($sQuery) use ($search) {
                        $sQuery->where('nama_series', 'like', '%' . $search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        match ($sort) {
            'terlama' => $query->orderBy('dibuat_pada', 'asc'),
            'az' => $query->orderBy('judul_buku', 'asc'),
            'za' => $query->orderBy('judul_buku', 'desc'),
            default => $query->orderBy('dibuat_pada', 'desc'), // terbaru
        };

        $buku = $query->paginate(12)->withQueryString();
        $kategori = \App\Models\Kategori::all();
        $series = \App\Models\Series::orderBy('nama_series', 'asc')->get();
        $banners = \App\Models\HeroBanner::where('is_active', true)
            ->orderBy('order_priority', 'asc')
            ->get();

        // Jika AJAX request, kembalikan JSON partial
        if ($request->ajax() || $request->has('ajax')) {
            $gridHtml = view('anggota.partials.buku-grid', compact('buku', 'isFilteringSeries'))->render();
            $paginationHtml = $buku->links()->toHtml();
            return response()->json([
                'html' => $gridHtml,
                'pagination' => $paginationHtml,
            ]);
        }

        return view('anggota.dashboard', compact('buku', 'kategori', 'series', 'banners', 'isFilteringSeries'));
    }


    /**
     * Detail Buku - halaman detail sebelum pinjam
     */
    public function detailBuku($id)
    {
        $buku = Buku::with([
            'kategori',
            'ulasan' => function ($q) {
                $q->latest('dibuat_pada');
            },
            'ulasan.anggota'
        ])->findOrFail($id);

        // Cek apakah anggota sedang meminjam buku ini
        $sedangMeminjam = Peminjaman::where('id_pengguna', Auth::id())
            ->where('id_buku', $id)
            ->whereIn('status_transaksi', ['booking', 'dipinjam'])
            ->exists();

        // Cek status verifikasi akun
        $akunTerverifikasi = Auth::user()->status === 'active';

        // Ambil buku terkait (kategori sama)
        $kategoriIds = $buku->kategori->pluck('id_kategori');
        $bukuTerkait = Buku::with('kategori')
            ->whereHas('kategori', function ($q) use ($kategoriIds) {
                $q->whereIn('kategori.id_kategori', $kategoriIds);
            })
            ->where('id_buku', '!=', $id)
            ->limit(4)
            ->get();

        // Ambil buku lain dalam series yang sama (jika ada)
        $seriesBooks = collect();
        if ($buku->id_series) {
            $seriesBooks = Buku::where('id_series', $buku->id_series)
                ->where('id_buku', '!=', $id)
                ->orderBy('nomor_volume')
                ->limit(4)
                ->get();
        }

        return view('anggota.detail-buku', compact('buku', 'sedangMeminjam', 'bukuTerkait', 'akunTerverifikasi', 'seriesBooks'));
    }

    /**
     * Detail Series (Menampilkan daftar buku dalam suatu Series)
     */
    public function detailSeries($id)
    {
        $series = \App\Models\Series::with(['buku.kategori'])->findOrFail($id);
        return view('anggota.detail-series', compact('series'));
    }

    /**
     * Pinjaman Saya
     */
    public function pinjaman()
    {
        $userId = Auth::id();

        // Update status terlambat secara otomatis
        Peminjaman::where('id_pengguna', $userId)
            ->where('status_transaksi', 'dipinjam')
            ->whereNotNull('tgl_jatuh_tempo')
            ->where('tgl_jatuh_tempo', '<', Carbon::today())
            ->update(['status_transaksi' => 'terlambat']);

        $pinjaman = Peminjaman::with('buku')
            ->where('id_pengguna', $userId)
            ->whereIn('status_transaksi', ['booking', 'dipinjam', 'terlambat'])
            ->orderBy('dibuat_pada', 'desc')
            ->get();

        $riwayat = Peminjaman::with('buku')
            ->where('id_pengguna', $userId)
            ->where('status_transaksi', 'dikembalikan')
            ->orderBy('tgl_kembali', 'desc')
            ->limit(5)
            ->get();

        return view('anggota.pinjaman', compact('pinjaman', 'riwayat'));
    }

    /**
     * Perpanjang Durasi Pinjam (max 3 hari, bisa dilakukan sekali)
     */
    public function perpanjang(Request $request, $id)
    {
        $userId = Auth::id();

        $peminjaman = Peminjaman::where('id_peminjaman', $id)
            ->where('id_pengguna', $userId)
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat'])
            ->firstOrFail();

        // Durasi perpanjangan: 2 atau 3 hari
        $request->validate([
            'tambah_hari' => 'required|integer|min:2|max:3',
        ]);

        $tambahHari = (int) $request->tambah_hari;

        // Hitung jatuh tempo baru
        $jatuhTempoLama = $peminjaman->tgl_jatuh_tempo ?? $peminjaman->tgl_kembali;
        $jatuhTempoBaru = Carbon::parse($jatuhTempoLama)->addDays($tambahHari);

        $peminjaman->update([
            'tgl_jatuh_tempo' => $jatuhTempoBaru,
            'durasi_pinjam' => ($peminjaman->durasi_pinjam ?? 0) + $tambahHari,
            'status_transaksi' => 'dipinjam', // reset jika terlambat
        ]);

        return redirect()->route('anggota.pinjaman')
            ->with('success', "Berhasil perpanjang peminjaman selama {$tambahHari} hari. Jatuh tempo baru: " . $jatuhTempoBaru->format('d M Y'));
    }

    /**
     * Store Booking (Pinjam Buku)
     */
    public function storeBooking(\App\Http\Requests\StoreBookingRequest $request)
    {
        // Cek status verifikasi akun anggota
        $user = Auth::user();
        if ($user->status !== 'active') {
            $pesan = match ($user->status) {
                'pending' => 'Akun Anda belum diverifikasi oleh admin. Silakan tunggu proses verifikasi.',
                'rejected' => 'Akun Anda ditolak oleh admin. Hubungi petugas untuk informasi lebih lanjut.',
                default => 'Akun Anda tidak dapat melakukan peminjaman saat ini.',
            };
            return redirect()->back()->with('error', $pesan);
        }

        // Cek apakah anggota memiliki denda yang belum dibayar
        $adaDendaBelumLunas = \App\Models\Denda::whereHas('peminjaman', function ($query) use ($user) {
            $query->where('id_pengguna', $user->id_pengguna);
        })->where('status_pembayaran', 'belum_bayar')->exists();

        if ($adaDendaBelumLunas) {
            return redirect()->back()->with('error', 'Peminjaman ditolak! Anda memiliki tagihan denda yang belum dilunasi. Harap lunasi denda Anda terlebih dahulu untuk bisa meminjam atau membooking buku.');
        }

        // Cek apakah ada buku yang sedang dipinjam tapi sudah lewat jatuh tempo (terlambat)
        $adaPeminjamanTerlambat = Peminjaman::where('id_pengguna', $user->id_pengguna)
            ->where(function($q) {
                $q->where('status_transaksi', 'terlambat')
                  ->orWhere(function($sq) {
                      $sq->where('status_transaksi', 'dipinjam')
                         ->whereDate('tgl_jatuh_tempo', '<', Carbon::today());
                  });
            })->exists();

        if ($adaPeminjamanTerlambat) {
            return redirect()->back()->with('error', 'Peminjaman ditolak! Anda memiliki buku yang terlambat dikembalikan. Harap kembalikan buku tersebut terlebih dahulu.');
        }

        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                // 1. Kunci baris buku eksklusif dengan lockForUpdate untuk mencegah race condition
                $buku = Buku::where('id_buku', $validated['id_buku'])
                            ->lockForUpdate()
                            ->firstOrFail();

                if ($buku->stok <= 0) {
                    throw new \Exception('Maaf, buku ini baru saja dipinjam orang lain (Stok Habis).');
                }

                // Cek apakah sudah pinjam buku ini
                $sudahPinjam = Peminjaman::where('id_pengguna', Auth::id())
                    ->where('id_buku', $validated['id_buku'])
                    ->whereIn('status_transaksi', ['booking', 'dipinjam'])
                    ->exists();

                if ($sudahPinjam) {
                    throw new \Exception('Anda sudah meminjam buku ini.');
                }

                // 2. Kurangi stok secara aman
                $buku->decrement('stok');

                $kodeBooking = Peminjaman::generateKodeBooking();
                $durasi = (int) $validated['durasi_pinjam'];
                $tglPinjam = Carbon::today();
                $tglJatuhTempo = $tglPinjam->copy()->addDays($durasi);

                // 3. Masukkan ke database
                Peminjaman::create([
                    'id_pengguna' => Auth::id(),
                    'id_buku' => $buku->id_buku,
                    'kode_booking' => $kodeBooking,
                    'tgl_booking' => $tglPinjam,
                    'tgl_pinjam' => $tglPinjam,
                    'durasi_pinjam' => $durasi,
                    'tgl_jatuh_tempo' => $tglJatuhTempo,
                    'status_transaksi' => 'booking',
                ]);

                // Simpan pesan sukses sementara di request via flash data (karena tidak mengembalikan response dalam closure)
                session()->flash('success_booking', "Booking berhasil! Kode Booking Anda: <strong>{$kodeBooking}</strong>. Tunjukkan kode ini ke petugas untuk mengambil buku. Jatuh tempo: {$tglJatuhTempo->format('d M Y')}");
            });

            return redirect()->route('anggota.pinjaman')->with('success', session('success_booking'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Riwayat & Denda
     */
    public function riwayat()
    {
        $userId = Auth::id();

        // Riwayat peminjaman yang sudah dikembalikan
        $history = Peminjaman::with(['buku', 'denda'])
            ->where('id_pengguna', $userId)
            ->where('status_transaksi', 'dikembalikan')
            ->orderBy('tgl_kembali', 'desc')
            ->get();

        // Tagihan denda yang sudah tercatat (biasanya setelah dikembalikan)
        $tagihanDenda = \App\Models\Denda::with(['peminjaman.buku'])
            ->whereHas('peminjaman', function ($q) use ($userId) {
                $q->where('id_pengguna', $userId);
            })
            ->where('status_pembayaran', 'belum_bayar')
            ->get();

        // Estimasi denda berjalan (untuk buku yang sedang dipinjam tapi terlambat)
        $dendaBerjalan = Peminjaman::with('buku')
            ->where('id_pengguna', $userId)
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat'])
            ->whereDate('tgl_jatuh_tempo', '<', Carbon::today())
            ->get()
            ->map(function ($loan) {
                $hariTerlambat = Carbon::today()->diffInDays($loan->tgl_jatuh_tempo);
                $loan->estimasi_denda = $hariTerlambat * 2000; // Rp 2.000 per hari
                $loan->hari_terlambat = $hariTerlambat;
                return $loan;
            });

        // Statistik Sederhana
        $stats = [
            'total_buku' => $history->count(),
            'total_denda' => $totalDendaOfficial = $tagihanDenda->sum('jumlah_denda'),
            'buku_terlambat' => $history->filter(fn($l) => $l->denda && $l->denda->jumlah_denda > 0)->count(),
            'member_since' => Auth::user()->dibuat_pada->locale('id')->isoFormat('MMMM YYYY'),
        ];

        return view('anggota.riwayat', compact('history', 'tagihanDenda', 'dendaBerjalan', 'stats'));
    }

    public function profile()
    {
        $user = Auth::user();
        $anggota = $user->anggota;
        return view('anggota.profile', compact('user', 'anggota'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Memastikan update hanya milik sendiri atau oleh admin
        \Illuminate\Support\Facades\Gate::authorize('update', $user);

        $anggota = $user->anggota;

        $request->validate([
            'email' => 'required|email|unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna',
            'nama_pengguna' => 'required|unique:pengguna,nama_pengguna,' . $user->id_pengguna . ',id_pengguna',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'nullable|min:6',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cropped_foto' => 'nullable|string',
        ]);

        if ($request->filled('cropped_foto')) {
            $image_parts = explode(";base64,", $request->cropped_foto);
            if (count($image_parts) == 2) {
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'profile_pictures/' . uniqid() . '.png';
                
                if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
                }
                
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
                $user->foto_profil = $fileName;
            }
        } elseif ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profile_pictures', 'public');
            $user->foto_profil = $path;
        }

        $user->email = $request->email;
        $user->nama_pengguna = $request->nama_pengguna;
        if ($request->filled('password')) {
            $user->kata_sandi = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        /** @var \App\Models\Pengguna $user */
        $user->save();

        $anggota->nama_lengkap = $request->nama_lengkap;
        $anggota->alamat = $request->alamat;
        /** @var \App\Models\Anggota $anggota */
        $anggota->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function hapusFotoProfil()
    {
        /** @var \App\Models\Anggota $user */
        $user = Auth::user();
        if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            $user->foto_profil = null;
            $user->save();
        }
        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Daftar pengajuan buku milik anggota yang sedang login
     */
    public function pengajuanBuku(Request $request)
    {
        $userId = Auth::id();

        $query = PengajuanBuku::where('id_pengguna', $userId)
            ->latest('dibuat_pada');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->paginate(10)->withQueryString();

        return view('anggota.pengajuan-buku.index', compact('pengajuan'));
    }

    /**
     * Detail satu pengajuan buku milik anggota
     */
    public function showPengajuan($id)
    {
        $userId = Auth::id();

        $pengajuan = PengajuanBuku::where('id_pengajuan', $id)
            ->where('id_pengguna', $userId)
            ->firstOrFail();

        return view('anggota.pengajuan-buku.show', compact('pengajuan'));
    }

    /**
     * Tampilkan kartu anggota
     */
    public function kartuAnggota()
    {
        $user = Auth::user();
        $anggota = $user->anggota;

        return view('anggota.kartu-anggota', compact('user', 'anggota'));
    }
}
