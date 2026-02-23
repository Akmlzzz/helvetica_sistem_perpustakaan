<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'isbn',
        'judul_buku',
        'penulis',
        'penerbit',
        'stok',
        'sinopsis',
        'jumlah_halaman',
        'tahun_terbit',
        'bahasa',
        'sampul',
        'lokasi_rak'
    ];

    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'buku_kategori', 'id_buku', 'id_kategori')
            ->withPivot('dibuat_pada', 'diperbarui_pada');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku');
    }

    public function getFormattedTahunTerbitAttribute()
    {
        return $this->tahun_terbit ? $this->tahun_terbit : 'Tidak diketahui';
    }

    public function getFormattedJumlahHalamanAttribute()
    {
        return $this->jumlah_halaman ? number_format($this->jumlah_halaman, 0, ',', '.') . ' halaman' : 'Tidak diketahui';
    }

    public function getSinopsisPreviewAttribute()
    {
        $preview = strip_tags($this->sinopsis);
        return strlen($preview) > 100 ? substr($preview, 0, 100) . '...' : $preview;
    }

    public function getFormattedBahasaAttribute()
    {
        $bahasaList = [
            'id' => 'Indonesia',
            'en' => 'English',
            'ar' => 'Arabic',
            'zh' => 'Chinese',
            'fr' => 'French',
            'de' => 'German',
            'ja' => 'Japanese',
            'ko' => 'Korean'
        ];

        return $bahasaList[$this->bahasa] ?? ucfirst($this->bahasa);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('judul_buku', 'like', "%{$search}%")
              ->orWhere('penulis', 'like', "%{$search}%")
              ->orWhere('penerbit', 'like', "%{$search}%")
              ->orWhere('isbn', 'like', "%{$search}%")
              ->orWhere('sinopsis', 'like', "%{$search}%");
        });
    }
}
