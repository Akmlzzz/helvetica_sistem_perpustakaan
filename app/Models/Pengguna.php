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

    public function isAdmin(): bool
    {
        return $this->level_akses === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->level_akses === 'petugas';
    }

    public function isAnggota(): bool
    {
        return $this->level_akses === 'anggota';
    }

    public function isUser(): bool
    {
        return in_array($this->level_akses, ['anggota', 'petugas']);
    }

    /**
     * Admin selalu boleh akses semua fitur.
     * Petugas hanya boleh akses fitur yang diberikan izin secara eksplisit.
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

    // ----------- Relationships -----------

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
     * Generate nomor anggota dengan format: ID-{urutan}-PX-{tahun}
     */
    public static function generateNomorAnggota(): string
    {
        $year = date('Y');
        $maxSequence = self::whereNotNull('nomor_anggota')
            ->where('nomor_anggota', 'like', "ID-%-PX-{$year}")
            ->pluck('nomor_anggota')
            ->map(fn($n) => (int) explode('-', $n)[1])
            ->max() ?? 0;

        return sprintf('ID-%d-PX-%s', $maxSequence + 1, $year);
    }

    public function approve(): void
    {
        $this->status = 'active';
        $this->nomor_anggota = self::generateNomorAnggota();
        $this->save();
    }

    public function reject(): void
    {
        $this->status = 'rejected';
        $this->save();
    }
}