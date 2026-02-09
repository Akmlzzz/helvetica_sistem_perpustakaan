<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        // Dashboard / Layanan Sirkulasi
        // Init variables for view
        return view('petugas.dashboard');
    }

    public function booking()
    {
        // Daftar Booking Online
        return view('petugas.booking');
    }

    public function katalog()
    {
        // Katalog Buku (Read Only)
        $buku = \App\Models\Buku::with('kategori')->paginate(10);
        return view('petugas.katalog', compact('buku'));
    }

    public function storePeminjaman(Request $request)
    {
        // Logic for borrowing book
        // Validation, Transaction creation, Stock update
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'buku_ids' => 'required|array',
            'buku_ids.*' => 'exists:buku,id_buku',
        ]);

        // Mock implementation
        return redirect()->back()->with('success', 'Peminjaman berhasil diproses');
    }

    public function returnBuku(Request $request)
    {
        // Logic for returning book
        // Calculate fine, update status
        return redirect()->back()->with('success', 'Pengembalian berhasil diproses');
    }
}
