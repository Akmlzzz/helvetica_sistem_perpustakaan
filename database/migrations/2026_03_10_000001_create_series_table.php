<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel series
        Schema::create('series', function (Blueprint $table) {
            $table->id('id_series');
            $table->string('nama_series', 255);
            $table->text('deskripsi')->nullable();
            $table->string('sampul_series')->nullable(); // opsional cover series
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamp('diperbarui_pada')->nullable();
        });

        // Tambah kolom id_series dan nomor_volume ke tabel buku
        Schema::table('buku', function (Blueprint $table) {
            $table->unsignedBigInteger('id_series')->nullable()->after('id_buku');
            $table->unsignedSmallInteger('nomor_volume')->nullable()->after('id_series');
            $table->foreign('id_series')->references('id_series')->on('series')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropForeign(['id_series']);
            $table->dropColumn(['id_series', 'nomor_volume']);
        });

        Schema::dropIfExists('series');
    }
};
