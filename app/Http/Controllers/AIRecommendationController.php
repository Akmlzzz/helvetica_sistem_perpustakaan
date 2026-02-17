<?php

namespace App\Http\Controllers;

use App\Models\AIRecommendation;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Services\GeminiAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AIRecommendationController extends Controller
{
    private GeminiAIService $aiService;

    public function __construct(GeminiAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Get recommendations for logged in user
     */
    public function index()
    {
        $userId = auth()->id();

        // Check for existing valid recommendations
        $recommendation = AIRecommendation::forUser($userId)
            ->active()
            ->latest('generated_at')
            ->first();

        // If no valid recommendation, generate new one
        if (!$recommendation || !$recommendation->isValid()) {
            $this->generateRecommendations($userId);
            $recommendation = AIRecommendation::forUser($userId)
                ->active()
                ->latest('generated_at')
                ->first();
        }

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada rekomendasi tersedia. Pinjam beberapa buku dulu!'
            ]);
        }

        // Get book details
        $books = $recommendation->getRecommendedBooksModels();

        return response()->json([
            'success' => true,
            'recommendations' => $books,
            'reasoning' => $recommendation->ai_reasoning,
            'generated_at' => $recommendation->generated_at->diffForHumans(),
        ]);
    }

    /**
     * Generate new recommendations for user
     */
    public function generate(Request $request)
    {
        $userId = $request->user()->id_pengguna;

        try {
            $result = $this->generateRecommendations($userId);

            return response()->json([
                'success' => true,
                'message' => 'Rekomendasi berhasil di-generate!',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate rekomendasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate recommendations logic
     */
    private function generateRecommendations($userId): ?AIRecommendation
    {
        // Get user's borrowing history
        $borrowedBooks = Peminjaman::where('id_pengguna', $userId)
            ->with('buku.kategori')
            ->latest('tgl_pinjam')
            ->take(10)
            ->get()
            ->map(function ($peminjaman) {
                return [
                    'judul_buku' => $peminjaman->buku->judul_buku ?? 'Unknown',
                    'penulis' => $peminjaman->buku->penulis ?? 'Unknown',
                    'kategori' => $peminjaman->buku->kategori->nama_kategori ?? 'Unknown',
                ];
            })
            ->toArray();

        // Check minimum history
        if (count($borrowedBooks) < (env('AI_MIN_BORROWING_HISTORY', 2))) {
            Log::info("User {$userId} doesn't have enough borrowing history");
            return null;
        }

        // Get available books (exclude already borrowed)
        $borrowedBookIds = Peminjaman::where('id_pengguna', $userId)
            ->pluck('id_buku')
            ->toArray();

        $availableBooks = Buku::with('kategori')
            ->whereNotIn('id_buku', $borrowedBookIds)
            ->where('stok', '>', 0)
            ->get()
            ->map(function ($buku) {
                return [
                    'id_buku' => $buku->id_buku,
                    'judul_buku' => $buku->judul_buku,
                    'penulis' => $buku->penulis ?? 'Unknown',
                    'kategori' => $buku->kategori->nama_kategori ?? 'Unknown',
                    'stok' => $buku->stok,
                ];
            })
            ->toArray();

        if (empty($availableBooks)) {
            Log::info("No available books for recommendations");
            return null;
        }

        // Generate AI recommendations
        $maxRecommendations = env('AI_MAX_RECOMMENDATIONS', 5);
        $aiResult = $this->aiService->generateBookRecommendations(
            $borrowedBooks,
            $availableBooks,
            $maxRecommendations
        );

        // Deactivate old recommendations
        AIRecommendation::where('id_pengguna', $userId)
            ->update(['is_active' => false]);

        // Save new recommendation
        $cacheDuration = env('AI_CACHE_DURATION', 10080); // 7 days default

        $recommendation = AIRecommendation::create([
            'id_pengguna' => $userId,
            'recommended_books' => $aiResult['recommendations'],
            'ai_reasoning' => $aiResult['reasoning'],
            'based_on_count' => count($borrowedBooks),
            'generated_at' => now(),
            'expires_at' => now()->addMinutes($cacheDuration),
            'is_active' => true,
        ]);

        Log::info("Generated recommendations for user {$userId}", [
            'count' => count($aiResult['recommendations']),
            'success' => $aiResult['success']
        ]);

        return $recommendation;
    }

    /**
     * Force refresh recommendations
     */
    public function refresh(Request $request)
    {
        $userId = $request->user()->id_pengguna;

        // Deactivate all current recommendations
        AIRecommendation::where('id_pengguna', $userId)
            ->update(['is_active' => false]);

        // Generate new
        $recommendation = $this->generateRecommendations($userId);

        if (!$recommendation) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa generate rekomendasi. Pastikan Anda sudah meminjam minimal 2 buku.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil di-refresh!',
        ]);
    }
}
