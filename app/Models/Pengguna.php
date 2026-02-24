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
        'status',
        'nomor_anggota',
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
     * Cek dia admin apa bukan
     */
    public function isAdmin(): bool
    {
        return $this->level_akses === 'admin';
    }

    /**
     * Cek dia petugas atau bukan
     */
    public function isPetugas(): bool
    {
        return $this->level_akses === 'petugas';
    }

    /**
     * Cek dia anggota biasa atau bukan
     */
    public function isAnggota(): bool
    {
        return $this->level_akses === 'anggota';
    }

    /**
     * Cek user biasa (anggota/petugas)
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

    /**
     * Cek apa masih nunggu verifikasi admin
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Cek kalo udah aktif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Cek kalo ditolak admin
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Buat kode nomor anggota otomatis
     */
    public static function generateNomorAnggota(): string
    {
        $year = date('Y');
        $lastMember = self::whereNotNull('nomor_anggota')
            ->orderBy('id_pengguna', 'desc')
            ->first();

        if ($lastMember) {
            $lastNumber = explode('-', $lastMember->nomor_anggota)[1] ?? 0;
            $newNumber = (int) $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "ID-{$newNumber}-PX-{$year}";
    }

    /**
     * ACC anggota baru + kasih nomor anggota
     */
    public function approve(): void
    {
        $this->status = 'active';
        $this->nomor_anggota = self::generateNomorAnggota();
        $this->save();
    }

    /**
     * Tolak anggota baru
     */
    public function reject(): void
    {
        $this->status = 'rejected';
        $this->save();
    }
}