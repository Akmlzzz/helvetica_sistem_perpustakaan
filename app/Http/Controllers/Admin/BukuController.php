<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'series']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->search($search);
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('kategori.id_kategori', $request->kategori);
            });
        }

        if ($request->has('series') && $request->series != '') {
            $query->where('id_series', $request->series);
        }

        // Sort
        if ($request->has('sort')) {
            if ($request->sort == 'terbaru') {
                $query->orderBy('dibuat_pada', 'desc');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('dibuat_pada', 'asc');
            } elseif ($request->sort == 'az') {
                $query->orderBy('judul_buku', 'asc');
            } else {
                $query->orderBy('dibuat_pada', 'desc');
            }
        } else {
            // Default sort
            $query->orderBy('dibuat_pada', 'desc');
        }

        $buku = $query->paginate(10);
        $kategori = Kategori::all();
        $series = Series::orderBy('nama_series')->get();

        return view('admin.buku.buku', compact('buku', 'kategori', 'series'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|regex:/^[0-9\-\s]+$/',
            'penulis' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
            'jumlah_halaman' => 'nullable|integer|min:1|max:10000',
            'tahun_terbit' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'bahasa' => 'nullable|string|in:id,en,ar,zh,fr,de,ja,ko',
            'kategori' => 'nullable|array',
            'kategori.*' => 'exists:kategori,id_kategori',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_rak' => 'nullable|string|max:50',
            'id_series' => 'nullable|exists:series,id_series',
            'nomor_volume' => 'nullable|integer|min:1',
        ]);

        $data = $request->except('kategori');

        if ($request->hasFile('sampul')) {
            $path = $request->file('sampul')->store('sampul', 'public');
            $data['sampul'] = $path;
        }

        $buku = Buku::create($data);

        if ($request->has('kategori')) {
            $buku->kategori()->attach($request->kategori);
        }

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|regex:/^[0-9\-\s]+$/',
            'penulis' => 'nullable|string|max:100',
            'penerbit' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
            'jumlah_halaman' => 'nullable|integer|min:1|max:10000',
            'tahun_terbit' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'bahasa' => 'nullable|string|in:id,en,ar,zh,fr,de,ja,ko',
            'kategori' => 'nullable|array',
            'kategori.*' => 'exists:kategori,id_kategori',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lokasi_rak' => 'nullable|string|max:50',
            'id_series' => 'nullable|exists:series,id_series',
            'nomor_volume' => 'nullable|integer|min:1',
        ]);

        $buku = Buku::findOrFail($id);
        $data = $request->except('kategori');

        // Jika id_series tidak dikirim (kosong string), set null
        if (empty($data['id_series'])) {
            $data['id_series'] = null;
            $data['nomor_volume'] = null;
        }

        if ($request->hasFile('sampul')) {
            // Delete old sampul if exists
            if ($buku->sampul && Storage::disk('public')->exists($buku->sampul)) {
                Storage::disk('public')->delete($buku->sampul);
            }
            $path = $request->file('sampul')->store('sampul', 'public');
            $data['sampul'] = $path;
        }

        $buku->update($data);

        if ($request->has('kategori')) {
            $buku->kategori()->sync($request->kategori);
        } else {
            $buku->kategori()->detach();
        }

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->sampul && Storage::disk('public')->exists($buku->sampul)) {
            Storage::disk('public')->delete($buku->sampul);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'series'])->findOrFail($id);
        $relatedBooks = Buku::whereHas('kategori', function ($query) use ($buku) {
            $query->whereIn('kategori.id_kategori', $buku->kategori->pluck('id_kategori'));
        })
            ->where('id_buku', '!=', $buku->id_buku)
            ->limit(6)
            ->get();

        // Series volumes jika buku ini bagian dari series
        $seriesVolumes = null;
        if ($buku->id_series) {
            $seriesVolumes = Buku::where('id_series', $buku->id_series)
                ->orderBy('nomor_volume')
                ->get();
        }

        return view('admin.buku.show', compact('buku', 'relatedBooks', 'seriesVolumes'));
    }
}
