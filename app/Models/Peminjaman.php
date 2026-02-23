<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'durasi_pinjam',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_jatuh_tempo',
        'status_transaksi'
    ];

    protected $casts = [
        'tgl_booking' => 'date',
        'tgl_pinjam' => 'date',
        'tgl_kembali' => 'date',
        'tgl_jatuh_tempo' => 'date',
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

    /**
     * Cek apakah peminjaman sudah terlambat
     */
    public function isTerlambat(): bool
    {
        $jatuhTempo = $this->tgl_jatuh_tempo ?? $this->tgl_kembali;
        if (!$jatuhTempo)
            return false;
        return Carbon::now()->startOfDay()->gt(Carbon::instance($jatuhTempo)->startOfDay());
    }

    /**
     * Hitung sisa hari
     */
    public function getSisaHariAttribute(): int
    {
        $jatuhTempo = $this->tgl_jatuh_tempo ?? $this->tgl_kembali;
        if (!$jatuhTempo)
            return 0;
        return (int) Carbon::now()->startOfDay()->diffInDays(Carbon::instance($jatuhTempo)->startOfDay(), false);
    }

    /**
     * Hitung keterlambatan dalam hari
     */
    public function getHariTerlambatAttribute(): int
    {
        if (!$this->isTerlambat())
            return 0;
        $jatuhTempo = $this->tgl_jatuh_tempo ?? $this->tgl_kembali;
        return (int) Carbon::now()->startOfDay()->diffInDays(Carbon::parse($jatuhTempo)->startOfDay());
    }

    /**
     * Generate kode booking unik
     */
    public static function generateKodeBooking(): string
    {
        do {
            $kode = 'BK' . date('ymd') . strtoupper(\Illuminate\Support\Str::random(4));
        } while (self::where('kode_booking', $kode)->exists());

        return $kode;
    }
}
