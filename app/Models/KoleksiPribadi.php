<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiPribadi extends Model
{
    protected $table = 'koleksi_pribadi';
    protected $primaryKey = 'id_koleksi';

    protected $fillable = [
        'id_pengguna',
        'id_buku',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
