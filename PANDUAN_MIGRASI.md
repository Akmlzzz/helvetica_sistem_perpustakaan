# Panduan Migrasi Database ke Bahasa Indonesia

## PERHATIAN: BACKUP WAJIB! ⚠️

Sebelum melakukan perubahan apapun, BACKUP database Anda terlebih dahulu!

## Status Penyelesaian

### ✅ 100% SELESAI

Semua file sudah diupdate:

- ✅ **12 Migration files** updated
- ✅ **7 Model files** updated
- ✅ **2 Controller files** updated
- ✅ **2 View files** updated

---

## Langkah-Langkah Implementasi

### Opsi 1: Fresh Migration (REKOMENDASI UNTUK TESTING)

Opsi ini akan menghapus semua data dan membuat tabel baru dengan struktur yang sudah diperbarui.

```bash
# 1. Backup database (WAJIB!)
php artisan db:backup  # Jika ada package backup

# 2. Reset migrations & seed ulang
php artisan migrate:fresh --seed

# 3. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 4. Optimize
php artisan optimize
```

### Opsi 2: Manual Rename Columns (UNTUK PRODUCTION DENGAN DATA)

Jika Anda memiliki data yang harus dipertahankan, gunakan migration untuk rename kolom:

**LANGKAH 1:** Buat migration baru

```bash
php artisan make:migration rename_columns_to_indonesian
```

**LANGKAH 2:** Edit file migration yang dihasilkan:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename timestamps di semua tabel
        $tables = ['pengguna', 'kategori', 'buku', 'anggota', 'peminjaman', 'detail_peminjaman', 'denda'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'created_at')) {
                        $table->renameColumn('created_at', 'dibuat_pada');
                    }
                    if (Schema::hasColumn($table->getTable(), 'updated_at')) {
                        $table->renameColumn('updated_at', 'diperbarui_pada');
                    }
                });
            }
        }

        // Rename kolom cover ke sampul di tabel buku
        if (Schema::hasTable('buku')) {
            Schema::table('buku', function (Blueprint $table) {
                if (Schema::hasColumn('buku', 'cover')) {
                    $table->renameColumn('cover', 'sampul');
                }
            });
        }

        // Rename tabel Laravel default
        if (Schema::hasTable('users')) {
            Schema::rename('users', 'pengguna_sistem');
        }
        if (Schema::hasTable('password_reset_tokens')) {
            Schema::rename('password_reset_tokens', 'token_reset_kata_sandi');
        }
        if (Schema::hasTable('sessions')) {
            Schema::rename('sessions', 'sesi');
        }
        if (Schema::hasTable('cache')) {
            Schema::rename('cache', 'tembolok');
        }
        if (Schema::hasTable('cache_locks')) {
            Schema::rename('cache_locks', 'kunci_tembolok');
        }
        if (Schema::hasTable('jobs')) {
            Schema::rename('jobs', 'pekerjaan');
        }
        if (Schema::hasTable('job_batches')) {
            Schema::rename('job_batches', 'batch_pekerjaan');
        }
        if (Schema::hasTable('failed_jobs')) {
            Schema::rename('failed_jobs', 'pekerjaan_gagal');
        }
    }

    public function down(): void
    {
        // Rollback semua perubahan
        // ... (tulis kebalikan dari up method)
    }
};
```

**LANGKAH 3:** Jalankan migration

```bash
# Install doctrine/dbal untuk rename columns
composer require doctrine/dbal

# Run migration
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan optimize
```

---

## Update Config Files (Opsional)

Jika Anda menggunakan tabel Laravel default, update config files:

### 1. config/auth.php

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\Pengguna::class,
        'table' => 'pengguna_sistem', // Update ini
    ],
],
```

### 2. config/session.php

```php
'table' => 'sesi', // Update dari 'sessions'
```

### 3. config/cache.php

```php
'stores' => [
    'database' => [
        'driver' => 'database',
        'table' => 'tembolok', // Update dari 'cache'
    ],
],
```

### 4. config/queue.php

```php
'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'pekerjaan', // Update dari 'jobs'
    ],
],
```

---

## Testing Checklist

Setelah migrasi, test semua fitur:

### ✅ Authentication

- [ ] Login
- [ ] Logout
- [ ] Register
- [ ] Forgot Password

### ✅ CRUD Operations

- [ ] Create Buku (dengan upload sampul)
- [ ] Read/View Buku (sampul tampil dengan benar)
- [ ] Update Buku (ganti sampul)
- [ ] Delete Buku (sampul terhapus dari storage)
- [ ] CRUD Category
- [ ] CRUD Pengguna
- [ ] CRUD Anggota
- [ ] CRUD Peminjaman
- [ ] CRUD Denda

### ✅ Laporan

- [ ] Laporan Buku (filter berdasarkan tanggal dibuat_pada)
- [ ] Laporan Anggota (filter berdasarkan tanggal dibuat_pada)
- [ ] Laporan Peminjaman
- [ ] Laporan Denda

### ✅ Storage

- [ ] Upload file sampul buku berfungsi
- [ ] File tersimpan di folder `/storage/app/public/sampul/`
- [ ] File tampil dengan benar di frontend
- [ ] File terhapus saat delete buku

---

## Troubleshooting

### Error: "Column not found"

Kemungkinan Anda belum menjalankan migration atau ada query yang masih menggunakan nama lama.

**Solusi:**

1. Check apakah migration sudah jalan: `php artisan migrate:status`
2. Search di codebase untuk nama kolom lama: grep atau Find in Files
3. Clear cache: `php artisan cache:clear`

### Storage Folder Tidak Ada

**Solusi:**

```bash
php artisan storage:link
mkdir storage/app/public/sampul
```

### Folder "covers" masih ada

Rename folder:

```bash
# Di Windows (PowerShell)
Move-Item "storage/app/public/covers" "storage/app/public/sampul"

# Di Linux/Mac
mv storage/app/public/covers storage/app/public/sampul
```

### Database timestamps tidak update

**Solusi:**
Pastikan semua model sudah ditambahkan konstanta:

```php
const CREATED_AT = 'dibuat_pada';
const UPDATED_AT = 'diperbarui_pada';
```

---

## Ringkasan Perubahan Nama

| **Tabel Lama**        | **Tabel Baru**         | **Kolom Lama**    | **Kolom Baru**           |
| --------------------- | ---------------------- | ----------------- | ------------------------ |
| users                 | pengguna_sistem        | name              | nama                     |
| users                 | pengguna_sistem        | password          | kata_sandi               |
| users                 | pengguna_sistem        | email_verified_at | email_terverifikasi_pada |
| password_reset_tokens | token_reset_kata_sandi | created_at        | dibuat_pada              |
| sessions              | sesi                   | user_id           | id_pengguna              |
| sessions              | sesi                   | ip_address        | alamat_ip                |
| sessions              | sesi                   | user_agent        | agen_pengguna            |
| sessions              | sesi                   | payload           | muatan                   |
| sessions              | sesi                   | last_activity     | aktivitas_terakhir       |
| cache                 | tembolok               | key               | kunci                    |
| cache                 | tembolok               | value             | nilai                    |
| cache                 | tembolok               | expiration        | kedaluwarsa              |
| cache_locks           | kunci_tembolok         | owner             | pemilik                  |
| jobs                  | pekerjaan              | queue             | antrian                  |
| jobs                  | pekerjaan              | payload           | muatan                   |
| jobs                  | pekerjaan              | attempts          | percobaan                |
| jobs                  | pekerjaan              | reserved_at       | disediakan_pada          |
| jobs                  | pekerjaan              | available_at      | tersedia_pada            |
| **Semua Tabel**       | -                      | **created_at**    | **dibuat_pada**          |
| **Semua Tabel**       | -                      | **updated_at**    | **diperbarui_pada**      |
| buku                  | -                      | **cover**         | **sampul**               |

---

## Next Steps

1. ✅ Backup database
2. ✅ Pilih opsi migrasi (Fresh vs Rename)
3. ✅ Jalankan migration
4. ✅ Clear all cache
5. ✅ Test semua fitur
6. ✅ Rename folder storage (covers → sampul) jika diperlukan
7. ✅ Deploy ke production (jika sudah testing berhasil)

---

## Catatan Penting

- **JANGAN** langsung deploy ke production tanpa testing di development dulu
- **BACKUP** database sebelum melakukan apapun
  -Jika ada error, rollback dengan `php artisan migrate:rollback`
- Folder `public/storage` harus di-link: `php artisan storage:link`

Semoga sukses! 🎉
