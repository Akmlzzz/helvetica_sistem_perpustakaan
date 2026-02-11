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
        Schema::create('pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('batch_pekerjaan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->integer('total_pekerjaan');
            $table->integer('pekerjaan_tertunda');
            $table->integer('pekerjaan_gagal');
            $table->longText('id_pekerjaan_gagal');
            $table->mediumText('opsi')->nullable();
            $table->integer('dibatalkan_pada')->nullable();
            $table->integer('dibuat_pada');
            $table->integer('selesai_pada')->nullable();
        });

        Schema::create('pekerjaan_gagal', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('koneksi');
            $table->text('antrian');
            $table->longText('muatan');
            $table->longText('pengecualian');
            $table->timestamp('gagal_pada')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaan');
        Schema::dropIfExists('batch_pekerjaan');
        Schema::dropIfExists('pekerjaan_gagal');
    }
};
