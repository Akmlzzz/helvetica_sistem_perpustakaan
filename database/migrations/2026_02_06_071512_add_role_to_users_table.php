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
        Schema::table('pengguna_sistem', function (Blueprint $table) {
            $table->enum('peran', ['admin', 'pengguna'])->default('pengguna')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna_sistem', function (Blueprint $table) {
            $table->dropColumn('peran');
        });
    }
};
