<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $user->loadMissing('hakAkses');

        // Fitur yang boleh diakses petugas ini
        $fiturAkses = $user->daftarFiturAkses();

        // Statistik
        $stats = [];
        if ($fiturAkses->contains('buku')) {
            $stats['buku'] = Buku::count();
        }
        if ($fiturAkses->contains('peminjaman')) {
            $stats['peminjaman_aktif'] = Peminjaman::whereIn('status_transaksi', ['dipinjam', 'terlambat'])->count();
            $stats['peminjaman_booking'] = Peminjaman::where('status_transaksi', 'booking')->count();
        }
        if ($fiturAkses->contains('denda')) {
            $stats['denda_belum_bayar'] = Denda::where('status_pembayaran', 'belum_bayar')->count();
        }
        if ($fiturAkses->contains('kategori')) {
            $stats['kategori'] = \App\Models\Kategori::count();
        }
        if ($fiturAkses->contains('laporan')) {
            $stats['laporan_bulan_ini'] = Peminjaman::whereMonth('tgl_pinjam', now()->month)
                ->whereYear('tgl_pinjam', now()->year)
                ->count();
        }

        // ==============================
        // Data untuk tab PEMINJAMAN (kode booking)
        // ==============================
        // Daftar booking online yang belum diambil (status = 'booking')
        $bookingAktif = Peminjaman::with(['pengguna.anggota', 'buku'])
            ->where('status_transaksi', 'booking')
            ->orderBy('dibuat_pada', 'desc')
            ->get();

        // ==============================
        // Data untuk tab PENGEMBALIAN
        // ==============================
        $searchReturn = $request->get('search_return');

        // Auto-update status terlambat
        Peminjaman::whereIn('status_transaksi', ['dipinjam'])
            ->whereNotNull('tgl_jatuh_tempo')
            ->where('tgl_jatuh_tempo', '<', Carbon::today())
            ->update(['status_transaksi' => 'terlambat']);

        $queryReturn = Peminjaman::with(['pengguna.anggota', 'buku'])
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat', 'booking']);

        if ($searchReturn) {
            $queryReturn->where(function ($q) use ($searchReturn) {
                $q->where('kode_booking', 'like', "%{$searchReturn}%")
                    ->orWhereHas('pengguna', function ($q2) use ($searchReturn) {
                        $q2->where('nama_pengguna', 'like', "%{$searchReturn}%");
                    })
                    ->orWhereHas('pengguna.anggota', function ($q2) use ($searchReturn) {
                        $q2->where('nama_lengkap', 'like', "%{$searchReturn}%");
                    })
                    ->orWhereHas('buku', function ($q2) use ($searchReturn) {
                        $q2->where('judul_buku', 'like', "%{$searchReturn}%");
                    });
            });
        }

        $peminjamanAktif = $queryReturn->orderByRaw("CASE
            WHEN status_transaksi = 'terlambat' THEN 1
            WHEN status_transaksi = 'dipinjam' THEN 2
            ELSE 3 END")
            ->orderBy('tgl_jatuh_tempo', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.dashboard', compact(
            'fiturAkses',
            'stats',
            'bookingAktif',
            'peminjamanAktif',
            'searchReturn'
        ));
    }

    public function katalog()
    {
        $buku = Buku::with('kategori')->paginate(10);
        return view('petugas.katalog', compact('buku'));
    }

    /**
     * Halaman Proses Booking (menu terpisah)
     */
    public function bookingPage(Request $request)
    {
        // Auto-update status terlambat
        Peminjaman::where('status_transaksi', 'dipinjam')
            ->whereNotNull('tgl_jatuh_tempo')
            ->where('tgl_jatuh_tempo', '<', Carbon::today())
            ->update(['status_transaksi' => 'terlambat']);

        $bookingAktif = Peminjaman::with(['pengguna.anggota', 'buku'])
            ->where('status_transaksi', 'booking')
            ->orderBy('dibuat_pada', 'desc')
            ->get();

        return view('petugas.booking', compact('bookingAktif'));
    }

    /**
     * Halaman Pengembalian Buku (menu terpisah)
     */
    public function pengembalianPage(Request $request)
    {
        $searchReturn = $request->get('search');

        // Auto-update status terlambat
        Peminjaman::where('status_transaksi', 'dipinjam')
            ->whereNotNull('tgl_jatuh_tempo')
            ->where('tgl_jatuh_tempo', '<', Carbon::today())
            ->update(['status_transaksi' => 'terlambat']);

        $query = Peminjaman::with(['pengguna.anggota', 'buku'])
            ->whereIn('status_transaksi', ['dipinjam', 'terlambat', 'booking']);

        if ($searchReturn) {
            $query->where(function ($q) use ($searchReturn) {
                $q->where('kode_booking', 'like', "%{$searchReturn}%")
                    ->orWhereHas('pengguna', fn($q2) => $q2->where('nama_pengguna', 'like', "%{$searchReturn}%"))
                    ->orWhereHas('pengguna.anggota', fn($q2) => $q2->where('nama_lengkap', 'like', "%{$searchReturn}%"))
                    ->orWhereHas('buku', fn($q2) => $q2->where('judul_buku', 'like', "%{$searchReturn}%"));
            });
        }

        $peminjamanAktif = $query
            ->orderByRaw("CASE
                WHEN status_transaksi = 'terlambat' THEN 1
                WHEN status_transaksi = 'dipinjam' THEN 2
                ELSE 3 END")
            ->orderBy('tgl_jatuh_tempo', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('petugas.pengembalian', compact('peminjamanAktif', 'searchReturn'));
    }

    /**
     * Proses kode booking dari anggota → ubah status ke 'dipinjam'
     * Ini hanya input kode booking — stok sudah dikurangi saat anggota booking online.
     */
    public function prosesBooking(Request $request)
    {
        $request->validate([
            'kode_booking' => 'required|string',
        ]);

        $peminjaman = Peminjaman::with(['buku', 'pengguna'])
            ->where('kode_booking', strtoupper(trim($request->kode_booking)))
            ->where('status_transaksi', 'booking')
            ->first();

        if (!$peminjaman) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode booking tidak ditemukan atau sudah diproses. Periksa kembali kode booking Anda.');
        }

        // Ubah status menjadi dipinjam (buku sudah diambil anggota)
        $peminjaman->update([
            'status_transaksi' => 'dipinjam',
            'tgl_pinjam' => Carbon::today(),
        ]);

        $namaBuku = $peminjaman->buku->judul_buku ?? '-';
        $namaAnggota = $peminjaman->pengguna->anggota->nama_lengkap
            ?? $peminjaman->pengguna->nama_pengguna
            ?? '-';

        return redirect()->route('petugas.dashboard')
            ->with('success', "Buku <strong>\"{$namaBuku}\"</strong> berhasil diserahkan ke <strong>{$namaAnggota}</strong>. Status diubah menjadi Dipinjam.");
    }

    /**
     * Proses pengembalian buku → hitung denda, restore stok, ubah status ke 'dikembalikan'
     */
    public function returnBuku(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id_peminjaman',
        ]);

        $peminjaman = Peminjaman::with('buku')->findOrFail($request->id_peminjaman);

        if ($peminjaman->status_transaksi === 'dikembalikan') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $pesanReturn = '';

        DB::transaction(function () use ($peminjaman, &$pesanReturn) {
            $jatuhTempo = $peminjaman->tgl_jatuh_tempo ?? $peminjaman->tgl_kembali;
            $tglKembaliAktual = Carbon::today();
            $dendaAmount = 0;

            // Hitung denda jika terlambat
            if ($jatuhTempo) {
                $jatuhTempoStr = is_string($jatuhTempo) ? $jatuhTempo : (string) $jatuhTempo;
                $jatuhTempoCarbon = Carbon::parse($jatuhTempoStr);

                if ($tglKembaliAktual->gt($jatuhTempoCarbon)) {
                    $hariTerlambat = (int) $tglKembaliAktual->diffInDays($jatuhTempoCarbon);
                    $dendaAmount = $hariTerlambat * 2000; // Rp 2.000/hari

                    // Cek sudah ada denda atau belum
                    $dendaExist = Denda::where('id_peminjaman', $peminjaman->id_peminjaman)->first();
                    if (!$dendaExist) {
                        Denda::create([
                            'id_peminjaman' => $peminjaman->id_peminjaman,
                            'jumlah_denda' => $dendaAmount,
                            'status_pembayaran' => 'belum_bayar',
                        ]);
                    }
                }
            }

            // Update peminjaman
            $peminjaman->update([
                'status_transaksi' => 'dikembalikan',
                'tgl_kembali' => $tglKembaliAktual,
            ]);

            // Restore stok buku
            if ($peminjaman->id_buku) {
                Buku::where('id_buku', $peminjaman->id_buku)->increment('stok');
            }

            $namaBuku = $peminjaman->buku->judul_buku ?? '-';
            if ($dendaAmount > 0) {
                $pesanReturn = "Buku <strong>\"{$namaBuku}\"</strong> berhasil dikembalikan. "
                    . "Terdapat denda keterlambatan sebesar <strong>Rp " . number_format($dendaAmount, 0, ',', '.') . "</strong>.";
            } else {
                $pesanReturn = "Buku <strong>\"{$namaBuku}\"</strong> berhasil dikembalikan tepat waktu.";
            }
        });

        return redirect()->route('petugas.dashboard')
            ->with('success', $pesanReturn);
    }
}
