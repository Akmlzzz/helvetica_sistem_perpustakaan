<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    use HasFactory;

    protected $table = 'hero_banners';

    protected $fillable = [
        'title_img',
        'char_img',
        'bg_img',
        'synopsis',
        'synopsis_color',
        'tags',
        'target_link',
        'id_series',
        'order_priority',
        'is_active',
    ];

    public function series()
    {
        return $this->belongsTo(\App\Models\Series::class, 'id_series', 'id_series');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'order_priority' => 'integer',
        'tags' => 'array', // Assuming we might want to cast it if we store as JSON, but user said "JSON or String". Let's stick to string for simplicity in migration but maybe accessor here.
    ];
}
