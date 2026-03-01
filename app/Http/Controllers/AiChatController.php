<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            return response()->json(['error' => 'API Key belum dikonfigurasi.'], 500);
        }

        // 1. Ambil Semua Kategori yang ada
        $semuaKategori = \App\Models\Kategori::pluck('nama_kategori')->implode(', ');

        // 2. Ambil 50 buku terbaru (context lebih luas)
        $daftarBuku = Buku::with('kategori')
            ->latest('dibuat_pada')
            ->take(50)
            ->get()
            ->map(function ($buku) {
                $kategori = $buku->kategori->pluck('nama_kategori')->implode(', ');
                $sinopsis = \Illuminate\Support\Str::limit($buku->sinopsis ?? '', 100);
                return "- {$buku->judul_buku} oleh {$buku->penulis} [Kategori: {$kategori}]. Ringkasan: {$sinopsis}";
            })
            ->implode("\n");

        // 3. Ambil Riwayat Peminjaman User (Jika ada)
        $riwayatUser = "";
        if (auth()->check()) {
            $userLoans = auth()->user()->peminjaman()
                ->with('buku')
                ->latest('tgl_pinjam')
                ->take(5)
                ->get();

            if ($userLoans->isNotEmpty()) {
                $riwayatUser = $userLoans->map(function ($loan) {
                    return $loan->buku ? "- " . $loan->buku->judul_buku : null;
                })->filter()->implode(", ");
            }
        }

        $userName = auth()->user()->nama_pengguna ?? 'Tamu';

        $systemInstructions = "Anda adalah 'Asisten Pustakawan AI' yang ahli dan sangat ramah.
            - Nama Pengguna: {$userName}.
            - Riwayat Bacaan Terakhir Pengguna: " . ($riwayatUser ?: 'Belum ada data riwayat') . ".
            - Kategori Buku yang Tersedia: {$semuaKategori}.
            - Katalog 50 Buku Terbaru di Sistem:
            {$daftarBuku}
            
            Tujuan Utama Anda: Membantu pengguna menemukan buku yang sesuai dengan minat mereka.
            Aturan Pemberian Rekomendasi:
            1. Jika pengguna bertanya 'ingin baca sesuatu' atau 'rekomendasi', jangan langsung kasih list panjang. Tanyakan dulu genre atau topik apa yang mereka suka hari ini.
            2. Jika mereka sudah memberikan riwayat bacaan, gunakan itu untuk menyarankan buku yang serupa dari katalog yang tersedia di atas.
            3. Berikan alasan 'Mengapa' Anda merekomendasikan buku tersebut (misal: 'Karena Anda suka genre fiksi, mungkin buku X cocok untuk Anda').
            4. Gunakan bahasa Indonesia yang asyik, tidak kaku, tapi tetap sopan.
            5. Batasi balasan Anda agar tetap ringkas namun informatif.
            6. Akhiri dengan ajakan untuk mengecek katalog lengkap jika mereka belum sreg.
            7. FORMAT JAWABAN WAJIB MENGGUNAKAN MARKDOWN: 
               - Gunakan huruf tebal (**teks**) untuk judul buku atau poin penting.
               - Gunakan daftar berpoin (`- `) atau penomoran (`1. `) untuk menyajikan lebih dari 1 pilihan.
               - Beri baris baru (enter/newline) antar paragraf atau antar list agar rapi dan tidak menyatu. Jangan tulis semua dalam 1 paragraf panjang.";

        $apiKey = trim($apiKey);

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [
                                    ['text' => $systemInstructions . "\n\nPesan Pengguna: " . $request->message]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 4096,
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya sedang tidak bisa merespons saat ini.';

                // Parse markdown into HTML securely
                $htmlReply = \Illuminate\Support\Str::markdown($reply, [
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                ]);

                return response()->json(['reply' => $htmlReply]);
            }

            Log::error('Gemini API Error: ' . $response->body());
            return response()->json(['error' => 'Gagal terhubung ke AI.'], 500);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem.'], 500);
        }
    }
}
