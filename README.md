# 📚 Biblio - Sistem Perpustakaan Digital Modern

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

---

## 📖 Deskripsi Proyek

**Biblio** adalah platform manajemen perpustakaan digital berbasis web yang dirancang untuk mentransformasi sistem pengelolaan perpustakaan konvensional menjadi ekosistem digital yang efisien, transparan, dan interaktif.

Dibangun dengan **Laravel 12** dan **Tailwind CSS 4**, aplikasi ini mengedepankan performa tinggi dengan antarmuka yang modern (premium UI/UX) dan responsif untuk berbagai perangkat.

---

## 🔥 Fitur Utama Berdasarkan Peran

Aplikasi ini menggunakan sistem **Role-Based Access Control (RBAC)** yang ketat untuk menjamin keamanan dan fleksibilitas akses:

### 🛠️ Mode Administrator (Owner)

- **Dashboard Visual Kontemporer**: Pantau performa perpustakaan melalui grafik interaktif dari _ApexCharts_.
- **Manajemen Hak Akses (RBAC)**: Konfigurasi izin spesifik bagi setiap petugas secara dinamis.
- **Pengawasan Pengajuan Buku**: Sistem kurasi untuk menyetujui atau menolak usulan buku dari anggota dengan catatan administrasi.
- **Pelaporan Akurat**: Generate laporan aktivitas dalam format ekspor PDF dan Excel.

### 📋 Mode Petugas (Staff)

- **Sirkulasi Kilat**: Manajemen peminjaman dan pengembalian dalam satu antarmuka terpadu.
- **Inventory Control**: Kelola metadata buku, kategori, dan stok secara real-time.
- **Gateway Peminjaman**: Verifikasi kode booking anggota untuk pengambilan fisik buku.

### 👤 Mode Anggota (Member)

- **Exploration Catalog**: Pencarian buku cerdas dengan filter kategori yang intuitif.
- **Smart Booking**: Sistem reservasi buku secara mandiri untuk menjamin ketersediaan.
- **Engagement Tools**: Usulkan buku favorit yang belum ada di katalog dan pantau progresnya melalui sistem **Notifikasi Real-time**.
- **Finance & History Transparency**: Rekam jejak peminjaman dan denda yang transparan.

---

## 💻 Tech Stack

Proyek ini dibangun menggunakan kombinasi teknologi terbaru:

- **Core Framework**: [Laravel 12.x](https://laravel.com)
- **Styling Engine**: [Tailwind CSS 4.0](https://tailwindcss.com) (Modern utility-first architecture)
- **Interactive UI**: [Alpine.js](https://alpinejs.dev) & [Blade UI Kit](https://blade-ui-kit.com)
- **Database**: [MySQL](https://www.mysql.com/) / [MariaDB](https://mariadb.org/)
- **Build Tool**: [Vite 6.0](https://vitejs.dev)
- **Analytics**: [ApexCharts](https://apexcharts.com)

---

## 🚀 Instalasi di Lingkungan Lokal

Ikuti urutan langkah di bawah ini untuk memulai:

### 1. Persiapan Awal

Pastikan mesin Anda telah terpasang:

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database Server (MySQL/MariaDB)

### 2. Kloning Repository & Dependensi

```bash
# Clone repository ini
git clone https://github.com/Akmlzzz/sistem-perpustakaan-digital.git

# Masuk ke folder project
cd sistem-perpustakaan-digital

# Install dependensi PHP
composer install

# Install dependensi JavaScript
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file contoh konfigurasi
cp .env.example .env

# Generate security key aplikasi
php artisan key:generate
```

### 4. Konfigurasi Database

Buka file `.env` dan sesuaikan pengaturan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_anda
DB_PASSWORD=password_anda
```

### 5. Inisialisasi Database

```bash
# Jalankan migrasi dan seeding data demo
php artisan migrate --seed
```

### 6. Menjalankan Aplikasi

Buka dua terminal berbeda:

- **Terminal 1**: `npm run dev` (Kompilasi asset frontend)
- **Terminal 2**: `php artisan serve` (Server aplikasi)

Akses aplikasi melalui: `http://localhost:8000`

---

## 🔑 Akun Demo (Default)

| Role              | Email                | Password   |
| :---------------- | :------------------- | :--------- |
| **Administrator** | `admin@biblio.com`   | `password` |
| **Petugas**       | `petugas@biblio.com` | `password` |
| **Anggota**       | `anggota@biblio.com` | `password` |

---

## 🗂️ Struktur Folder Utama

- `app/Http/Controllers/` : Logika bisnis aplikasi.
- `resources/views/` : Template UI (Blade files).
- `database/migrations/` : Skema basis data.
- `routes/web.php` : Definisi rute aplikasi.

---

## 📄 Lisensi

Didistribusikan di bawah lisensi [MIT](LICENSE).

**Biblio** - Mengubah cara Anda membaca dan mengelola ilmu pengetahuan.  
Didesain oleh [Akmlzzz](https://github.com/Akmlzzz).
