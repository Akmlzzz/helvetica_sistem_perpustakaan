<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'id_series';
    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'nama_series',
        'deskripsi',
        'sampul_series',
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_series')->orderBy('nomor_volume');
    }

    public function getTotalVolumeAttribute()
    {
        return $this->buku()->count();
    }
}
