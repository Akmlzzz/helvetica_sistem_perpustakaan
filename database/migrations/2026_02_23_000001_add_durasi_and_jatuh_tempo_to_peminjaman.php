<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->unsignedInteger('durasi_pinjam')->nullable()->after('tgl_booking')->comment('Durasi pinjam dalam hari (maks 14)');
            $table->date('tgl_jatuh_tempo')->nullable()->after('durasi_pinjam')->comment('Tanggal jatuh tempo pengembalian');
            // nullable id_buku (sudah ada) - kita update enum status
        });

        // Update status enum untuk mendukung 'terlambat'
        // (sudah ada di migration awal, skip)
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['durasi_pinjam', 'tgl_jatuh_tempo']);
        });
    }
};
