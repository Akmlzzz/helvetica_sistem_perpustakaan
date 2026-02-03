<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda');
            $table->unsignedBigInteger('id_peminjaman')->unique();
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
            $table->decimal('jumlah_denda', 10, 2);
            $table->enum('status_pembayaran', ['belum_bayar', 'lunas']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
