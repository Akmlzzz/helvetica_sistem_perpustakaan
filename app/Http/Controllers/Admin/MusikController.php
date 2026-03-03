<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Musik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusikController extends Controller
{
    public function index()
    {
        $musikList = Musik::orderBy('urutan')->orderBy('id')->get();
        return view('admin.musik.index', compact('musikList'));
    }

    public function store(Request $request)
    {
        $sumberTipe = $request->input('sumber_tipe', 'url'); // 'url' atau 'file'

        if ($sumberTipe === 'file') {
            $request->validate([
                'judul' => 'required|string|max:255',
                'artis' => 'required|string|max:255',
                'file_audio' => 'required|file|mimes:mp3,ogg|max:51200', // max 50MB
                'urutan' => 'nullable|integer|min:0',
            ], [
                'file_audio.required' => 'File audio wajib diupload.',
                'file_audio.mimes' => 'Format file harus MP3 atau OGG.',
                'file_audio.max' => 'Ukuran file maksimal 50MB.',
            ]);

            $path = $request->file('file_audio')->store('musik', 'public');

            Musik::create([
                'judul' => $request->judul,
                'artis' => $request->artis,
                'url' => '',
                'file_path' => $path,
                'aktif' => $request->boolean('aktif', true),
                'urutan' => $request->input('urutan', 0),
            ]);
        } else {
            $request->validate([
                'judul' => 'required|string|max:255',
                'artis' => 'required|string|max:255',
                'url' => 'required|url|max:500',
                'urutan' => 'nullable|integer|min:0',
            ], [
                'url.url' => 'URL lagu tidak valid. Masukkan URL lengkap (mulai dengan http:// atau https://).',
            ]);

            Musik::create([
                'judul' => $request->judul,
                'artis' => $request->artis,
                'url' => $request->url,
                'file_path' => null,
                'aktif' => $request->boolean('aktif', true),
                'urutan' => $request->input('urutan', 0),
            ]);
        }

        return back()->with('success', "Lagu \"{$request->judul}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Musik $musik)
    {
        $sumberTipe = $request->input('sumber_tipe', 'url');

        if ($sumberTipe === 'file' && $request->hasFile('file_audio')) {
            $request->validate([
                'judul' => 'required|string|max:255',
                'artis' => 'required|string|max:255',
                'file_audio' => 'required|file|mimes:mp3,ogg|max:51200', // max 50MB
                'urutan' => 'nullable|integer|min:0',
            ], [
                'file_audio.mimes' => 'Format file harus MP3 atau OGG.',
                'file_audio.max' => 'Ukuran file maksimal 50MB.',
            ]);

            // Hapus file lama jika ada
            if ($musik->file_path) {
                Storage::disk('public')->delete($musik->file_path);
            }

            $path = $request->file('file_audio')->store('musik', 'public');

            $musik->update([
                'judul' => $request->judul,
                'artis' => $request->artis,
                'url' => '',
                'file_path' => $path,
                'aktif' => $request->boolean('aktif'),
                'urutan' => $request->input('urutan', 0),
            ]);
        } else {
            $request->validate([
                'judul' => 'required|string|max:255',
                'artis' => 'required|string|max:255',
                'url' => 'required|url|max:500',
                'urutan' => 'nullable|integer|min:0',
            ]);

            // Hapus file lama jika sebelumnya pakai file, sekarang ganti ke URL
            if ($musik->file_path) {
                Storage::disk('public')->delete($musik->file_path);
            }

            $musik->update([
                'judul' => $request->judul,
                'artis' => $request->artis,
                'url' => $request->url,
                'file_path' => null,
                'aktif' => $request->boolean('aktif'),
                'urutan' => $request->input('urutan', 0),
            ]);
        }

        return back()->with('success', "Lagu \"{$musik->judul}\" berhasil diperbarui.");
    }

    public function destroy(Musik $musik)
    {
        $judul = $musik->judul;

        // Hapus file fisik jika ada
        if ($musik->file_path) {
            Storage::disk('public')->delete($musik->file_path);
        }

        $musik->delete();
        return back()->with('success', "Lagu \"{$judul}\" berhasil dihapus.");
    }

    public function toggleAktif(Musik $musik)
    {
        $musik->update(['aktif' => !$musik->aktif]);
        $status = $musik->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Lagu \"{$musik->judul}\" berhasil {$status}.");
    }
}
