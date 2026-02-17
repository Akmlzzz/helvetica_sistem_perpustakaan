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
        $books = \Illuminate\Support\Facades\DB::table('buku')
            ->whereNotNull('id_kategori')
            ->get();

        foreach ($books as $book) {
            \Illuminate\Support\Facades\DB::table('buku_kategori')->insert([
                'id_buku' => $book->id_buku,
                'id_kategori' => $book->id_kategori,
                'dibuat_pada' => now(),
                'diperbarui_pada' => now(),
            ]);
        }

        // Optional: Set id_kategori to null after migration if you want to clean up
        // \Illuminate\Support\Facades\DB::table('buku')->update(['id_kategori' => null]);
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('buku_kategori')->truncate();
    }
};
