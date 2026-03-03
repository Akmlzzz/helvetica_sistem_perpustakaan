<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('musik', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('artis');
            $table->string('url'); // bisa URL langsung atau path file yang diupload
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('musik');
    }
};
