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
        $query = Buku::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', '%' . $search . '%')
                    ->orWhere('penulis', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
                    ->orWhere('sinopsis', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        $buku = $query->paginate(12)->withQueryString();
        $kategori = \App\Models\Kategori::all();

        // Jika AJAX request, kembalikan JSON partial
        if ($request->ajax() || $request->has('ajax')) {
            $gridHtml = view('anggota.partials.buku-grid', compact('buku'))->render();
            $paginationHtml = $buku->links()->toHtml();
            return response()->json([
                'html' => $gridHtml,
                'pagination' => $paginationHtml,
            ]);
        }

        return view('anggota.dashboard', compact('buku', 'kategori'));
    }


    /**
     * Detail Buku - halaman detail sebelum pinjam
     */
    public function detailBuku($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);

        // Cek apakah anggota sedang meminjam buku ini
        $sedangMeminjam = Peminjaman::where('id_pengguna', Auth::id())
            ->where('id_buku', $id)
            ->whereIn('status_transaksi', ['booking', 'dipinjam'])
            ->exists();

        // Ambil buku terkait (kategori sama)
        $kategoriIds = $buku->kategori->pluck('id_kategori');
        $bukuTerkait = Buku::with('kategori')
            ->whereHas('kategori', function ($q) use ($kategoriIds) {
                $q->whereIn('kategori.id_kategori', $kategoriIds);
            })
            ->where('id_buku', '!=', $id)
            ->limit(4)
            ->get();

        return view('anggota.detail-buku', compact('buku', 'sedangMeminjam', 'bukuTerkait'));
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
    public function storeBooking(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'durasi_pinjam' => 'required|integer|min:1|max:14',
        ]);

        $buku = Buku::findOrFail($request->id_buku);

        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Cek apakah sudah pinjam buku ini
        $sudahPinjam = Peminjaman::where('id_pengguna', Auth::id())
            ->where('id_buku', $request->id_buku)
            ->whereIn('status_transaksi', ['booking', 'dipinjam'])
            ->exists();

        if ($sudahPinjam) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        $kodeBooking = Peminjaman::generateKodeBooking();
        $durasi = (int) $request->durasi_pinjam;
        $tglPinjam = Carbon::today();
        $tglJatuhTempo = $tglPinjam->copy()->addDays($durasi);

        DB::transaction(function () use ($request, $kodeBooking, $durasi, $tglPinjam, $tglJatuhTempo) {
            Peminjaman::create([
                'id_pengguna' => Auth::id(),
                'id_buku' => $request->id_buku,
                'kode_booking' => $kodeBooking,
                'tgl_booking' => $tglPinjam,
                'tgl_pinjam' => $tglPinjam,
                'durasi_pinjam' => $durasi,
                'tgl_jatuh_tempo' => $tglJatuhTempo,
                'status_transaksi' => 'dipinjam',
            ]);

            Buku::where('id_buku', $request->id_buku)->decrement('stok');
        });

        return redirect()->route('anggota.pinjaman')
            ->with('success', "Buku berhasil dipinjam! Kode Booking Anda: {$kodeBooking}. Jatuh tempo: {$tglJatuhTempo->format('d M Y')}");
    }

    /**
     * Riwayat & Denda
     */
    public function riwayat()
    {
        $userId = Auth::id();

        $history = Peminjaman::with(['buku', 'denda'])
            ->where('id_pengguna', $userId)
            ->where('status_transaksi', 'dikembalikan')
            ->orderBy('tgl_kembali', 'desc')
            ->get();

        $tagihanDenda = \App\Models\Denda::with(['peminjaman.buku'])
            ->whereHas('peminjaman', function ($q) use ($userId) {
                $q->where('id_pengguna', $userId);
            })
            ->where('status_pembayaran', 'belum_lunas')
            ->get();

        return view('anggota.riwayat', compact('history', 'tagihanDenda'));
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
        $anggota = $user->anggota;

        $request->validate([
            'email' => 'required|email|unique:pengguna,email,' . $user->id_pengguna . ',id_pengguna',
            'nama_pengguna' => 'required|unique:pengguna,nama_pengguna,' . $user->id_pengguna . ',id_pengguna',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'password' => 'nullable|min:6',
        ]);

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
