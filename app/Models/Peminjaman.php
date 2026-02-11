<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'id_pengguna',
        'id_buku',
        'kode_booking',
        'tgl_booking',
        'tgl_pinjam',
        'tgl_kembali',
        'status_transaksi'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function detail()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_peminjaman');
    }
}
