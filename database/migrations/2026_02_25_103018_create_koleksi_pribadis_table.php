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
        Schema::create('koleksi_pribadi', function (Blueprint $table) {
            $table->id('id_koleksi');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksi_pribadi');
    }
};
