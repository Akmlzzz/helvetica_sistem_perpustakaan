<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIRecommendation extends Model
{
    protected $table = 'ai_recommendations';
    protected $primaryKey = 'id_recommendation';

    protected $fillable = [
        'id_pengguna',
        'recommended_books',
        'ai_reasoning',
        'based_on_count',
        'generated_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'recommended_books' => 'array',
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'based_on_count' => 'integer'
    ];

    /**
     * Get the user that owns the recommendation
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Get recommended books as Buku models
     */
    public function getRecommendedBooksModels()
    {
        $bookIds = collect($this->recommended_books)->pluck('id_buku')->toArray();
        return Buku::whereIn('id_buku', $bookIds)->get();
    }

    /**
     * Check if recommendation is still valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Scope for active recommendations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope for user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('id_pengguna', $userId);
    }
}
