<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('musik', function (Blueprint $table) {
            // file_path untuk menyimpan path file audio yang diupload (nullable)
            $table->string('file_path')->nullable()->after('url');
        });
    }

    public function down(): void
    {
        Schema::table('musik', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
