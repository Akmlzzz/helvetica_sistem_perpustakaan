<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->unsignedBigInteger('id_series')->nullable()->after('target_link');
            $table->foreign('id_series')->references('id_series')->on('series')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->dropForeign(['id_series']);
            $table->dropColumn('id_series');
        });
    }
};
