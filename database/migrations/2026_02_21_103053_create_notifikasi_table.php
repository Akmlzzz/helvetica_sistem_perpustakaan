<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_pengguna'); // penerima notifikasi
            $table->enum('tipe', ['pengajuan_baru', 'status_pengajuan']); // jenis notifikasi
            $table->string('judul', 255); // judul notif
            $table->text('pesan'); // isi pesan
            $table->unsignedBigInteger('id_pengajuan')->nullable(); // referensi ke pengajuan buku
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan_buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
