<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hak_akses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengguna');
            $table->enum('fitur', ['kategori', 'buku', 'peminjaman', 'denda']);
            $table->timestamps();

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            $table->unique(['id_pengguna', 'fitur']); // Satu petugas tidak boleh duplikat fitur
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hak_akses');
    }
};
