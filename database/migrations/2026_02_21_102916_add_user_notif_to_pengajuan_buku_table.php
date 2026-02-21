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
        Schema::table('pengajuan_buku', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pengguna')->nullable()->after('nama_pengusul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_buku', function (Blueprint $table) {
            $table->dropColumn('id_pengguna');
        });
    }
};

