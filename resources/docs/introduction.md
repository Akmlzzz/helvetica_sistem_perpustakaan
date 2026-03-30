# Pengenalan Sistem Perpustakaan Digital Biblio

Selamat datang di dokumentasi resmi **Sistem Perpustakaan Digital Biblio**. Panduan ini ditujukan untuk admin dan developer yang bertanggung jawab mengelola dan mengembangkan sistem ini.

## Apa itu Biblio?

**Biblio** adalah sistem manajemen perpustakaan digital berbasis web yang dibangun menggunakan **Laravel 11** dan **Alpine.js**. Sistem ini dirancang untuk memudahkan pengelolaan koleksi buku, peminjaman, pengembalian, serta denda secara otomatis dan efisien.

## Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|---|---|---|
| Laravel | 11.x | Backend framework (PHP) |
| Alpine.js | 3.x | Reaktivitas UI ringan |
| Vite | 5.x | Build tool & asset bundler |
| PostgreSQL / MySQL | - | Database relasional |
| Tailwind CSS | 3.x | Utility-first CSS (via CDN) |
| Midtrans | - | Payment gateway untuk denda |

## Struktur Role Pengguna

Sistem ini memiliki **3 tingkatan akses** utama:

- **Admin** — Akses penuh ke seluruh fitur sistem, manajemen pengguna, laporan, dan konfigurasi
- **Petugas** — Akses terbatas sesuai izin yang diberikan admin (e.g., buku, peminjaman, denda)
- **Anggota** — Pengguna publik yang dapat meminjam buku, melihat katalog, dan membayar denda

## Fitur Utama

### Manajemen Koleksi
- Input buku satuan atau batch (massal)
- Kategori & Series buku
- Pencarian & filter katalog

### Peminjaman & Pengembalian
- Sistem booking online oleh anggota
- Konfirmasi serah terima oleh petugas
- Perpanjangan peminjaman
- Riwayat transaksi lengkap

### Denda Otomatis
- Perhitungan denda per hari keterlambatan
- Integrasi pembayaran via Midtrans (Snap)
- Notifikasi denda ke anggota

### Dashboard & Laporan
- Statistik real-time (buku, anggota, peminjaman aktif)
- Grafik peminjaman mingguan
- Export laporan ke PDF & Excel

## Cara Memulai

Untuk menjalankan proyek ini secara lokal, ikuti langkah berikut:

```bash
# 1. Clone repositori
git clone <repo-url>

# 2. Install dependency PHP
composer install

# 3. Install dependency JavaScript
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Jalankan migrasi & seeder
php artisan migrate --seed

# 7. Jalankan server development
php artisan serve
npm run dev
```

## Struktur Direktori Penting

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/        # Controller khusus admin
│   │   ├── Anggota/      # Controller panel anggota
│   │   └── Petugas/      # Controller panel petugas
│   └── Middleware/        # Auth & role middleware
├── Models/               # Eloquent models
└── Helpers/              # Helper class (MenuHelper, dll)
resources/
├── views/
│   ├── layouts/          # Layout utama (app, auth, sidebar)
│   ├── admin/            # Halaman panel admin
│   ├── anggota/          # Halaman panel anggota
│   └── petugas/          # Halaman panel petugas
└── docs/                 # File dokumentasi Markdown ini
```

> **Catatan:** Dokumentasi ini bersifat living document dan akan terus diperbarui seiring perkembangan sistem.
