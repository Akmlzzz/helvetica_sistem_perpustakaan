<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->text('sinopsis')->nullable()->after('stok');
            $table->string('isbn', 20)->nullable()->change();
            $table->integer('jumlah_halaman')->nullable()->after('penerbit');
            $table->string('penerbit', 255)->nullable()->change();
            $table->year('tahun_terbit')->nullable()->after('jumlah_halaman');
            $table->string('bahasa', 50)->nullable()->after('tahun_terbit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['sinopsis', 'jumlah_halaman', 'tahun_terbit', 'bahasa']);
        });
    }
};
