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

    public function createBatch()
    {
        $kategori = Kategori::all();
        $series = Series::orderBy('nama_series')->get();
        $buku_tanpa_series = Buku::whereNull('id_series')->orderBy('judul_buku')->get();
        // Buku yang sudah punya series (untuk fitur pindah series)
        $buku_dalam_series = Buku::with('series')->whereNotNull('id_series')->orderBy('judul_buku')->get();
        return view('admin.buku.batch', compact('kategori', 'series', 'buku_tanpa_series', 'buku_dalam_series'));
    }

    public function assignSeriesBatch(Request $request)
    {
        $request->validate([
            'id_series' => 'required|exists:series,id_series',
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:buku,id_buku'
        ], [
            'id_series.required' => 'Pilih series terlebih dahulu.',
            'buku_ids.required' => 'Pilih minimal satu buku untuk dimasukkan ke series.',
        ]);

        Buku::whereIn('id_buku', $request->buku_ids)->update([
            'id_series' => $request->id_series
        ]);

        return redirect()->route('admin.buku.batch')->with('success', count($request->buku_ids) . ' buku berhasil ditambahkan ke dalam series!');
    }

    public function moveToSeries(Request $request)
    {
        $request->validate([
            'id_series_tujuan' => 'required|exists:series,id_series',
            'buku_pindah_ids'  => 'required|array|min:1',
            'buku_pindah_ids.*' => 'exists:buku,id_buku',
        ], [
            'id_series_tujuan.required' => 'Pilih series tujuan terlebih dahulu.',
            'buku_pindah_ids.required'  => 'Pilih minimal satu buku untuk dipindahkan.',
        ]);

        Buku::whereIn('id_buku', $request->buku_pindah_ids)->update([
            'id_series' => $request->id_series_tujuan
        ]);

        $seriesTujuan = Series::find($request->id_series_tujuan);
        $count = count($request->buku_pindah_ids);

        return redirect()->route('admin.buku.batch')->with('success', $count . ' buku berhasil dipindahkan ke series "' . $seriesTujuan->nama_series . '"!');
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            // Common Info
            'judul_buku_common' => 'required|string|max:255',
            'penulis_common' => 'nullable|string|max:100',
            'penerbit_common' => 'nullable|string|max:255',
            'tahun_terbit_common' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'bahasa_common' => 'nullable|string|in:id,en,ar,zh,fr,de,ja,ko',
            'lokasi_rak_common' => 'nullable|string|max:50',
            'id_series' => 'nullable|exists:series,id_series',
            'kategori' => 'nullable|array',
            'kategori.*' => 'exists:kategori,id_kategori',

            // Items
            'items' => 'required|array|min:1',
            'items.*.nomor_volume' => 'nullable|integer|min:1',
            'items.*.isbn' => 'nullable|string|max:20',
            'items.*.stok' => 'required|integer|min:0',
            'items.*.sinopsis' => 'nullable|string',
            'items.*.sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            foreach ($request->items as $index => $itemData) {
                $data = [
                    'judul_buku' => $request->judul_buku_common,
                    'penulis' => $request->penulis_common,
                    'penerbit' => $request->penerbit_common,
                    'tahun_terbit' => $request->tahun_terbit_common,
                    'bahasa' => $request->bahasa_common,
                    'lokasi_rak' => $request->lokasi_rak_common,
                    'id_series' => $request->id_series,
                    'nomor_volume' => $itemData['nomor_volume'] ?? null,
                    'isbn' => $itemData['isbn'] ?? null,
                    'stok' => $itemData['stok'],
                    'sinopsis' => $itemData['sinopsis'] ?? null,
                    'sampul' => null,
                ];

                // Jika ada upload gambar di baris tertentu
                if ($request->hasFile("items.$index.sampul")) {
                    $path = $request->file("items.$index.sampul")->store('sampul', 'public');
                    $data['sampul'] = $path;
                }

                $buku = Buku::create($data);

                if ($request->has('kategori')) {
                    $buku->kategori()->attach($request->kategori);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('admin.buku.index')->with('success', count($request->items) . ' buku berhasil ditambahkan sekaligus!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan batch buku: ' . $e->getMessage())->withInput();
        }
    }
}
