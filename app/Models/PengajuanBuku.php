<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanBuku extends Model
{
    protected $table = 'pengajuan_buku';
    protected $primaryKey = 'id_pengajuan';
    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'judul_buku',
        'nama_penulis',
        'isbn',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'id_pengguna',
        'nama_pengusul',
        'alasan_pengusulan',
        'status',
        'catatan_admin',
        'sudah_dibaca',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'dibuat_pada' => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    /**
     * Scope untuk pengajuan yang belum dibaca admin
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    /**
     * Scope untuk pengajuan dengan status menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    /**
     * Label status dalam Bahasa Indonesia
     */
    public function getLabelStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Warna badge untuk status
     */
    public function getWarnaStatusAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'yellow',
            'disetujui' => 'green',
            'ditolak' => 'red',
            default => 'gray',
        };
    }

    /**
     * Relasi ke pengguna yang mengajukan
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
