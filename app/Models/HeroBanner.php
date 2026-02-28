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
        'tags',
        'target_link',
        'order_priority',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_priority' => 'integer',
        'tags' => 'array', // Assuming we might want to cast it if we store as JSON, but user said "JSON or String". Let's stick to string for simplicity in migration but maybe accessor here.
    ];
}
