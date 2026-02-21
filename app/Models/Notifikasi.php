<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = true;

    protected $fillable = [
        'id_pengguna',
        'tipe',
        'judul',
        'pesan',
        'id_pengajuan',
        'sudah_dibaca',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
    ];

    /**
     * Relasi ke pengguna (penerima notifikasi)
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Relasi ke pengajuan buku
     */
    public function pengajuanBuku()
    {
        return $this->belongsTo(PengajuanBuku::class, 'id_pengajuan', 'id_pengajuan');
    }

    /**
     * Scope notifikasi belum dibaca
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    /**
     * Icon berdasarkan tipe
     */
    public function getIconAttribute(): string
    {
        return match ($this->tipe) {
            'pengajuan_baru' => 'book-open',
            'status_pengajuan' => 'check-circle',
            default => 'bell',
        };
    }

    /**
     * Warna berdasarkan tipe dan konten pesan
     */
    public function getWarnaBadgeAttribute(): string
    {
        if ($this->tipe === 'pengajuan_baru') {
            return 'blue';
        }
        if (str_contains($this->pesan, 'disetujui')) {
            return 'green';
        }
        if (str_contains($this->pesan, 'ditolak')) {
            return 'red';
        }
        return 'yellow';
    }
}
