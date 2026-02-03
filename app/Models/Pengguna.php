<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    // public $timestamps = false; // Removed as Authenticatable typically uses timestamps

    protected $fillable = [
        'nama_pengguna',
        'email',
        'kata_sandi',
        'level_akses',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    protected function casts(): array
    {
        return [
            'kata_sandi' => 'hashed',
        ];
    }

    // RELATIONSHIP
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'id_pengguna');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_pengguna');
    }
}