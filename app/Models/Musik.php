<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musik extends Model
{
    protected $table = 'musik';

    protected $fillable = [
        'judul',
        'artis',
        'url',
        'file_path',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan')->orderBy('id');
    }

    /**
     * Kembalikan URL audio yang digunakan player.
     * Prioritas: file upload lokal > URL eksternal
     */
    public function getAudioUrlAttribute(): string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return $this->url ?? '';
    }
}
