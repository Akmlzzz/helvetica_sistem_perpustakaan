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
        Schema::create('ai_recommendations', function (Blueprint $table) {
            $table->id('id_recommendation');
            $table->unsignedBigInteger('id_pengguna');
            $table->json('recommended_books'); // Array of book IDs with scores
            $table->text('ai_reasoning')->nullable(); // Why these books?
            $table->integer('based_on_count')->default(0); // Based on X borrowed books
            $table->timestamp('generated_at');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key
            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('cascade');

            // Indexes for performance
            $table->index('id_pengguna');
            $table->index(['id_pengguna', 'is_active']);
            $table->index('generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recommendations');
    }
};
