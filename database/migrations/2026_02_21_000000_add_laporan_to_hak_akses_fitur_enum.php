<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Tambahkan 'laporan' ke enum kolom 'fitur' di tabel hak_akses.
     * Karena Laravel tidak support modifikasi enum langsung di semua DB driver,
     * kita gunakan raw SQL yang aman untuk MySQL.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table since SQLite doesn't support MODIFY COLUMN
        if (DB::getDriverName() === 'sqlite') {
            // SQLite approach: skip this migration as enum constraints are not enforced in SQLite
            // The 'laporan' value will be handled at application level
            return;
        }
        
        // MySQL approach: Modify enum column to add 'laporan'
        DB::statement("ALTER TABLE hak_akses MODIFY COLUMN fitur ENUM('kategori', 'buku', 'peminjaman', 'denda', 'laporan') NOT NULL");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite approach: skip this migration
            return;
        }
        
        // Hapus 'laporan' dari enum (pastikan tidak ada baris yang pakai 'laporan' sebelum rollback)
        DB::statement("DELETE FROM hak_akses WHERE fitur = 'laporan'");
        DB::statement("ALTER TABLE hak_akses MODIFY COLUMN fitur ENUM('kategori', 'buku', 'peminjaman', 'denda') NOT NULL");
    }
};
