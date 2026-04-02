<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_buku', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->string('judul_buku', 255);
            $table->string('nama_penulis', 255);
            $table->string('isbn', 20)->nullable();
            $table->string('penerbit', 255)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('nama_pengusul', 255);
            $table->text('alasan_pengusulan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_buku');
    }
};
