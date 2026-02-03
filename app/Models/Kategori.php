<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = ['nama_kategori'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_kategori');
    }
}
