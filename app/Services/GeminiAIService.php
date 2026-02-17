<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeminiAIService
{
    private string $apiKey;
    private string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    private string $model = 'gemini-1.5-flash'; // Free model!

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
    }

    /**
     * Generate book recommendations based on user history
     */
    public function generateBookRecommendations(
        array $borrowedBooks,
        array $availableBooks,
        int $maxRecommendations = 5
    ): array {
        try {
            $prompt = $this->buildRecommendationPrompt($borrowedBooks, $availableBooks, $maxRecommendations);

            $response = $this->makeRequest($prompt);

            return $this->parseRecommendationResponse($response);
        } catch (\Exception $e) {
            Log::error('Gemini AI Error: ' . $e->getMessage());

            // Fallback: return random recommendations
            return $this->getFallbackRecommendations($availableBooks, $maxRecommendations);
        }
    }

    /**
     * Build prompt for book recommendations
     */
    private function buildRecommendationPrompt(
        array $borrowedBooks,
        array $availableBooks,
        int $maxRecommendations
    ): string {
        $borrowedList = collect($borrowedBooks)->map(function ($book) {
            return "- {$book['judul_buku']} by {$book['penulis']} (Kategori: {$book['kategori']})";
        })->join("\n");

        $availableList = collect($availableBooks)->map(function ($book) {
            return "ID: {$book['id_buku']} | {$book['judul_buku']} by {$book['penulis']} | Kategori: {$book['kategori']} | Stok: {$book['stok']}";
        })->join("\n");

        return <<<PROMPT
Kamu adalah AI librarian yang ahli dalam merekomendasikan buku.

USER TELAH MEMINJAM BUKU BERIKUT:
{$borrowedList}

BUKU YANG TERSEDIA DI PERPUSTAKAAN:
{$availableList}

TUGAS:
Berdasarkan riwayat peminjaman user, rekomendasikan {$maxRecommendations} buku terbaik dari buku yang tersedia.

CRITICAL: Berikan response dalam format JSON yang VALID seperti ini (no markdown, no code blocks):
{
  "recommendations": [
    {
      "id_buku": 123,
      "score": 95,
      "reason": "Alasan singkat kenapa direkomendasikan"
    }
  ],
  "reasoning": "Penjelasan umum tentang pola pembacaan user"
}

ATURAN:
1. Hanya pilih dari buku yang TERSEDIA (ada di list)
2. Prioritaskan buku yang stok > 0
3. Pertimbangkan kategori, penulis, dan tema yang mirip
4. Score 0-100 (100 = paling cocok)
5. HARUS valid JSON, NO MARKDOWN, NO code blocks
6. Urutkan dari score tertinggi
PROMPT;
    }

    /**
     * Make request to Gemini API
     */
    private function makeRequest(string $prompt): array
    {
        $url = $this->apiUrl . $this->model . ':generateContent?key=' . $this->apiKey;

        $response = Http::timeout(30)
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

        if (!$response->successful()) {
            throw new \Exception('Gemini API request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Parse Gemini response
     */
    private function parseRecommendationResponse(array $response): array
    {
        try {
            $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Clean markdown code blocks if present
            $text = preg_replace('/```json\s*/i', '', $text);
            $text = preg_replace('/```\s*$/i', '', $text);
            $text = trim($text);

            $data = json_decode($text, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from AI: ' . json_last_error_msg());
            }

            return [
                'success' => true,
                'recommendations' => $data['recommendations'] ?? [],
                'reasoning' => $data['reasoning'] ?? 'AI analysis completed',
            ];
        } catch (\Exception $e) {
            Log::error('Failed to parse AI response: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fallback recommendations (random popular books)
     */
    private function getFallbackRecommendations(array $availableBooks, int $max): array
    {
        $random = collect($availableBooks)
            ->where('stok', '>', 0)
            ->random(min($max, count($availableBooks)))
            ->map(function ($book) {
                return [
                    'id_buku' => $book['id_buku'],
                    'score' => rand(50, 80),
                    'reason' => 'Buku populer di perpustakaan'
                ];
            })
            ->toArray();

        return [
            'success' => false,
            'recommendations' => $random,
            'reasoning' => 'Rekomendasi fallback karena AI tidak tersedia',
        ];
    }

    /**
     * Generate smart search results
     */
    public function smartSearch(string $query, array $availableBooks): array
    {
        $cacheKey = 'ai_search_' . md5($query);

        if (env('AI_CACHE_ENABLED', true)) {
            return Cache::remember($cacheKey, 3600, function () use ($query, $availableBooks) {
                return $this->performSmartSearch($query, $availableBooks);
            });
        }

        return $this->performSmartSearch($query, $availableBooks);
    }

    private function performSmartSearch(string $query, array $availableBooks): array
    {
        // Similar implementation for smart search
        // Can be implemented later
        return [];
    }
}
