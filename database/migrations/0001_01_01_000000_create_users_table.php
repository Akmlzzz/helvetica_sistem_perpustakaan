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
        Schema::create('pengguna_sistem', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_terverifikasi_pada')->nullable();
            $table->string('kata_sandi');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('token_reset_kata_sandi', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('dibuat_pada')->nullable();
        });

        Schema::create('sesi', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna_sistem');
        Schema::dropIfExists('token_reset_kata_sandi');
        Schema::dropIfExists('sesi');
    }
};
