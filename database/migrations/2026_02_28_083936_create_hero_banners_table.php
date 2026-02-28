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
        Schema::dropIfExists('hero_banners');
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title_img')->nullable();
            $table->string('char_img')->nullable();
            $table->string('bg_img');
            $table->text('synopsis')->nullable();
            $table->string('tags')->nullable();
            $table->string('target_link')->nullable();
            $table->integer('order_priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};
