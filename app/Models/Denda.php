<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'jumlah_denda',
        'status_pembayaran'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}
