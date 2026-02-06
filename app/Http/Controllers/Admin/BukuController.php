<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('penulis', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori', $request->kategori);
        }

        $buku = $query->paginate(10);
        $kategori = Kategori::all();

        return view('admin.buku.buku', compact('buku', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'penulis' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $path;
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'penulis' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_rak' => 'nullable|string|max:50',
        ]);

        $buku = Buku::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $path = $request->file('cover')->store('covers', 'public');
            $data['cover'] = $path;
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
