<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Pengguna;
use App\Models\Peminjaman;
use App\Models\Denda;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $type = $request->input('type', 'peminjaman');

        $data = $this->getReportData($type, $startDate, $endDate);

        // Calculate summary statistics for peminjaman report
        $totalPeminjaman = 0;
        $totalTerlambat = 0;
        $totalDikembalikan = 0;

        if ($type === 'peminjaman') {
            $totalPeminjaman = $data->count();
            $totalTerlambat = $data->where('status_transaksi', 'terlambat')->count();
            $totalDikembalikan = $data->where('status_transaksi', 'dikembalikan')->count();
        }

        return view('admin.laporan.index', compact('data', 'startDate', 'endDate', 'type', 'totalPeminjaman', 'totalTerlambat', 'totalDikembalikan'));
    }

    private function getReportData($type, $startDate, $endDate)
    {
        switch ($type) {
            case 'buku':
                return Buku::with('kategori')
                    ->whereBetween('dibuat_pada', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();
            case 'anggota':
                return Pengguna::with('anggota')
                    ->where('level_akses', 'anggota')
                    ->whereBetween('dibuat_pada', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();
            case 'peminjaman':
                return Peminjaman::with(['pengguna.anggota', 'detail.buku', 'denda'])
                    ->whereBetween('tgl_pinjam', [$startDate, $endDate])
                    ->get();
            case 'denda':
                return Denda::with(['peminjaman.pengguna.anggota'])
                    ->whereHas('peminjaman', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tgl_kembali', [$startDate, $endDate]);
                    })
                    ->get();
            default:
                return collect();
        }
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $type = $request->input('type', 'peminjaman');

        $data = $this->getReportData($type, $startDate, $endDate);

        return view('admin.laporan.print', compact('data', 'startDate', 'endDate', 'type'));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $type = $request->input('type', 'peminjaman');

        $data = $this->getReportData($type, $startDate, $endDate);

        $fileName = 'Laporan_' . ucfirst($type) . '_' . $startDate . '_to_' . $endDate . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($data, $type) {
            $file = fopen('php://output', 'w');

            if ($type == 'buku') {
                fputcsv($file, ['ID', 'ISBN', 'Judul', 'Penulis', 'Penerbit', 'Stok', 'Lokasi']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->id_buku, $row->isbn, $row->judul_buku, $row->penulis, $row->penerbit, $row->stok, $row->lokasi_rak]);
                }
            } elseif ($type == 'anggota') {
                fputcsv($file, ['ID', 'Username', 'Email', 'Nama Lengkap', 'Alamat', 'Telepon', 'Tgl Registrasi']);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->id_pengguna,
                        $row->nama_pengguna,
                        $row->email,
                        $row->anggota->nama_lengkap ?? '-',
                        $row->anggota->alamat ?? '-',
                        $row->anggota->nomor_telepon ?? '-',
                        $row->dibuat_pada->format('Y-m-d')
                    ]);
                }
            } elseif ($type == 'peminjaman') {
                fputcsv($file, ['ID Peminjaman', 'Peminjam', 'Buku', 'Tgl Pinjam', 'Tgl Kembali', 'Status', 'Denda']);
                foreach ($data as $row) {
                    $books = $row->detail->pluck('buku.judul_buku')->implode(', ');
                    fputcsv($file, [
                        $row->id_peminjaman,
                        $row->pengguna->nama_pengguna,
                        $books,
                        $row->tgl_pinjam,
                        $row->tgl_kembali ?? '-',
                        $row->status_transaksi,
                        $row->denda->jumlah_denda ?? 0
                    ]);
                }
            } elseif ($type == 'denda') {
                fputcsv($file, ['ID Denda', 'Peminjam', 'ID Peminjaman', 'Tgl Kembali', 'Jumlah Denda', 'Status']);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->id_denda,
                        $row->peminjaman->pengguna->nama_pengguna,
                        $row->id_peminjaman,
                        $row->peminjaman->tgl_kembali,
                        $row->jumlah_denda,
                        $row->status_pembayaran
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
