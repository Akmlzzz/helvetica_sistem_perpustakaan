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
        Schema::table('hak_akses', function (Blueprint $table) {
            $table->string('fitur', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hak_akses', function (Blueprint $table) {
            // Revert back if needed, assuming the original definition
            $table->enum('fitur', ['kategori', 'buku', 'peminjaman', 'denda', 'laporan'])->change();
        });
    }
};
