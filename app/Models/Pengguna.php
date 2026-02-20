<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class Pengguna extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';
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

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->level_akses === 'admin';
    }

    /**
     * Check if user is petugas (officer)
     */
    public function isPetugas(): bool
    {
        return $this->level_akses === 'petugas';
    }

    /**
     * Check if user is anggota (member)
     */
    public function isAnggota(): bool
    {
        return $this->level_akses === 'anggota';
    }

    /**
     * Check if user is regular user (anggota or petugas)
     */
    public function isUser(): bool
    {
        return in_array($this->level_akses, ['anggota', 'petugas']);
    }

    /**
     * Cek apakah user boleh mengakses fitur tertentu.
     * Admin selalu boleh akses semua, petugas hanya yang diberikan izin.
     */
    public function canAccess(string $fitur): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->hakAkses->pluck('fitur')->contains($fitur);
    }

    /**
     * Ambil daftar nama fitur yang dimiliki petugas ini.
     */
    public function daftarFiturAkses(): Collection
    {
        return $this->hakAkses->pluck('fitur');
    }

    // ----------- RELATIONSHIPS -----------

    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'id_pengguna');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_pengguna');
    }

    public function hakAkses()
    {
        return $this->hasMany(HakAkses::class, 'id_pengguna', 'id_pengguna');
    }
}