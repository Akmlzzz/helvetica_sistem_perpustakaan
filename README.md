# Sistem Perpustakaan Digital

Proyek ini dibuat untuk memenuhi tugas UKK (Uji Kompetensi Keahlian) / Proyek Akhir. Sistem ini digunakan untuk mengelola data buku, anggota, serta transaksi peminjaman dan pengembalian di perpustakaan.

## Fitur Utama

- Manajemen Data Buku & Kategori
- Manajemen Anggota & Petugas
- Transaksi Peminjaman (Booking & Pinjam Langsung)
- Perhitungan Denda Otomatis
- Laporan Transaksi
- Notifikasi Sistem

## Teknologi yang Digunakan

- **Framework:** Laravel 11
- **Styling:** Tailwind CSS & Flowbite
- **Database:** MySQL
- **Frontend Interactivity:** Alpine.js

## Cara Instalasi

1. Clone / download project ini.
2. Jalankan `composer install` dan `npm install`.
3. Salin file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi databasenya.
4. Jalankan `php artisan key:generate`.
5. Jalankan `php artisan migrate --seed`.
6. Jalankan `php artisan serve` dan `npm run dev`.

## Akun Login Default

- **Admin:** admin / password
- **Petugas:** petugas / password
- **Anggota:** anggota / password
