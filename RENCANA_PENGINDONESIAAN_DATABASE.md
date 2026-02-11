# Rencana Pengindonesiaan Database

## Ringkasan

Dokumen ini berisi rencana lengkap untuk mengubah semua penamaan database dari bahasa Inggris ke bahasa Indonesia.

## Tabel dan Kolom yang Perlu Diubah

### 1. Tabel `users` (Laravel Default)

**Nama Tabel Baru:** `pengguna` (sudah ada tabel terpisah)
**Catatan:** Tabel users adalah tabel default Laravel. Karena sudah ada tabel `pengguna`, sebaiknya:

- Hapus/disable tabel `users`
- Atau tetap gunakan tabel `users` untuk autentikasi Laravel dan hubungkan dengan `pengguna`

**Kolom yang perlu diubah:**

- `name` → `nama`
- `email` → `email` (tetap)
- `password` → `kata_sandi`
- `email_verified_at` → `email_terverifikasi_pada`
- `remember_token` → `token_ingat_saya`
- `created_at` → `dibuat_pada`
- `updated_at` → `diperbarui_pada`
- `role` → `peran`

### 2. Tabel `password_reset_tokens`

**Nama Tabel Baru:** `token_reset_kata_sandi`

**Kolom yang perlu diubah:**

- `email` → `email` (tetap)
- `token` → `token` (tetap - istilah teknis)
- `created_at` → `dibuat_pada`

### 3. Tabel `sessions`

**Nama Tabel Baru:** `sesi`

**Kolom yang perlu diubah:**

- `id` → `id` (tetap)
- `user_id` → `id_pengguna`
- `ip_address` → `alamat_ip`
- `user_agent` → `agen_pengguna`
- `payload` → `muatan`
- `last_activity` → `aktivitas_terakhir`

### 4. Tabel `cache` (Laravel Default)

**Nama Tabel Baru:** `tembolok`

**Kolom yang perlu diubah:**

- `key` → `kunci`
- `value` → `nilai`
- `expiration` → `kedaluwarsa`

### 5. Tabel `jobs` (Laravel Default)

**Nama Tabel Baru:** `pekerjaan`

**Kolom yang perlu diubah:**

- `id` → `id` (tetap)
- `queue` → `antrian`
- `payload` → `muatan`
- `attempts` → `percobaan`
- `reserved_at` → `disediakan_pada`
- `available_at` → `tersedia_pada`
- `created_at` → `dibuat_pada`

### 6. Tabel `pengguna` ✅ (Sudah Indonesia)

**Status:** Sudah menggunakan bahasa Indonesia

- `id_pengguna` ✅
- `nama_pengguna` ✅
- `email` ✅
- `kata_sandi` ✅
- `level_akses` ✅
- `created_at` → `dibuat_pada`
- `updated_at` → `diperbarui_pada`

### 7. Tabel `kategori` ✅ (Sudah Indonesia)

**Status:** Sudah menggunakan bahasa Indonesia

- `id_kategori` ✅
- `nama_kategori` ✅
- `created_at` → `dibuat_pada`
- `updated_at` → `diperbarui_pada`

### 8. Tabel `buku` (Perlu Update Timestamp)

**Status:** Sebagian besar sudah Indonesia, perlu tambah timestamps

- `id_buku` ✅
- `isbn` ✅ (istilah internasional)
- `cover` → `sampul`
- `judul_buku` ✅
- `penulis` ✅
- `penerbit` ✅
- `stok` ✅
- `lokasi_rak` ✅
- `id_kategori` ✅
- Perlu tambah: `dibuat_pada`, `diperbarui_pada`

### 9. Tabel `anggota` ✅ (Sudah Indonesia)

**Status:** Sudah menggunakan bahasa Indonesia

- `id_anggota` ✅
- `id_pengguna` ✅
- `nama_lengkap` ✅
- `alamat` ✅
- `nomor_telepon` ✅
- `created_at` → `dibuat_pada`
- `updated_at` → `diperbarui_pada`

### 10. Tabel `peminjaman` (Perlu Update Timestamp)

**Status:** Sudah menggunakan bahasa Indonesia

- `id_peminjaman` ✅
- `id_pengguna` ✅
- `id_buku` ✅
- `kode_booking` ✅
- `tgl_booking` ✅
- `tgl_pinjam` ✅
- `tgl_kembali` ✅
- `status_transaksi` ✅
- Perlu tambah: `dibuat_pada`, `diperbarui_pada`

### 11. Tabel `detail_peminjaman` (Perlu Update Timestamp)

**Status:** Sudah menggunakan bahasa Indonesia

- `id_detail` ✅
- `id_peminjaman` ✅
- `id_buku` ✅
- `jumlah` ✅
- Perlu tambah: `dibuat_pada`, `diperbarui_pada`

### 12. Tabel `denda` (Perlu Update Timestamp)

**Status:** Sudah menggunakan bahasa Indonesia

- `id_denda` ✅
- `id_peminjaman` ✅
- `jumlah_denda` ✅
- `status_pembayaran` ✅
- Perlu tambah: `dibuat_pada`, `diperbarui_pada`

## Strategi Implementasi

### Fase 1: Update Timestamps pada Tabel yang Sudah Indonesia

1. Aktifkan timestamps pada model Buku, Peminjaman, DetailPeminjaman, Denda
2. Update migrations untuk menambahkan kolom timestamps dengan nama Indonesia

### Fase 2: Ubah Nama Kolom Laravel Default

1. Buat custom column names untuk timestamps di semua model
2. Update `users` table atau migrate ke tabel `pengguna`
3. Update tabel `sessions`, `password_reset_tokens`, `cache`, `jobs`

### Fase 3: Update Kolom yang Masih Inggris

1. `cover` → `sampul` di tabel buku

### Fase 4: Update Kode Aplikasi

1. Update semua Controller
2. Update semua View (Blade templates)
3. Update semua Query
4. Update Middleware
5. Update Seeder & Factory

## Catatan Penting

### Timestamps Laravel

Laravel secara default menggunakan `created_at` dan `updated_at`. Untuk mengubahnya:

```php
// Di Model
const CREATED_AT = 'dibuat_pada';
const UPDATED_AT = 'diperbarui_pada';
```

### Foreign Keys

Pastikan foreign keys di update sesuai dengan nama kolom baru.

### Breaking Changes

⚠️ **PERHATIAN:** Perubahan ini akan membutuhkan:

1. Backup database terlebih dahulu
2. Fresh migration atau manual column rename
3. Update semua kode yang mengakses database
4. Testing menyeluruh setelah perubahan

## Rekomendasi

Karena scope perubahan sangat besar, saya sarankan:

1. **Opsi A (Konservatif):** Hanya update tabel custom (pengguna, buku, dll) dan biarkan tabel Laravel default tetap Inggris
2. **Opsi B (Full Indonesia):** Update semua termasuk tabel Laravel dengan custom column names
3. **Opsi C (Hybrid):** Gunakan accessor/mutator untuk menyediakan interface Indonesia tanpa mengubah database

Mana yang Anda pilih?
