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

        $data = collect();

        switch ($type) {
            case 'buku':
                $data = Buku::with('kategori')
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();
                break;
            case 'anggota':
                $data = Pengguna::where('level_akses', 'anggota')
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();
                break;
            case 'peminjaman':
                $data = Peminjaman::with(['pengguna', 'detail.buku'])
                    ->whereBetween('tgl_pinjam', [$startDate, $endDate])
                    ->get();
                break;
            case 'denda':
                $data = Denda::with(['peminjaman.pengguna'])
                    ->whereHas('peminjaman', function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('tgl_kembali', [$startDate, $endDate]);
                    })
                    ->get();
                break;
        }

        return view('admin.laporan.index', compact('data', 'startDate', 'endDate', 'type'));
    }

    public function exportPdf(Request $request)
    {
        // Placeholder for PDF export
        return back()->with('success', 'Fitur Cetak PDF sedang dikembangkan.');
    }

    public function exportExcel(Request $request)
    {
        // Placeholder for Excel export
        return back()->with('success', 'Fitur Export Excel sedang dikembangkan.');
    }
}
