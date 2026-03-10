<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Series::withCount('buku');

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where('nama_series', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $series = $query->orderBy('nama_series')->paginate(10);

        return view('admin.series.index', compact('series'));
    }

    public function show($id)
    {
        $series = Series::with(['buku.kategori'])->findOrFail($id);
        return view('admin.series.show', compact('series'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_series' => 'required|string|max:255|unique:series,nama_series',
            'deskripsi' => 'nullable|string',
            'sampul_series' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_series', 'deskripsi']);

        if ($request->hasFile('sampul_series')) {
            $data['sampul_series'] = $request->file('sampul_series')->store('series', 'public');
        }

        Series::create($data);

        return redirect()->route('admin.series.index')->with('success', 'Series berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $series = Series::findOrFail($id);

        $request->validate([
            'nama_series' => 'required|string|max:255|unique:series,nama_series,' . $id . ',id_series',
            'deskripsi' => 'nullable|string',
            'sampul_series' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_series', 'deskripsi']);

        if ($request->hasFile('sampul_series')) {
            if ($series->sampul_series && Storage::disk('public')->exists($series->sampul_series)) {
                Storage::disk('public')->delete($series->sampul_series);
            }
            $data['sampul_series'] = $request->file('sampul_series')->store('series', 'public');
        }

        $series->update($data);

        return redirect()->route('admin.series.index')->with('success', 'Series berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $series = Series::findOrFail($id);

        // Lepas semua buku dari series ini
        Buku::where('id_series', $id)->update(['id_series' => null, 'nomor_volume' => null]);

        if ($series->sampul_series && Storage::disk('public')->exists($series->sampul_series)) {
            Storage::disk('public')->delete($series->sampul_series);
        }

        $series->delete();

        return redirect()->route('admin.series.index')->with('success', 'Series berhasil dihapus!');
    }
}
