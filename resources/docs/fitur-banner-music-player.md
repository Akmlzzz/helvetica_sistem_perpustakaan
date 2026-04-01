# Manajemen Banner & Music Player

Fitur **Manajemen Banner** dan **Music Player** adalah sepasang fitur konten media yang bertujuan meningkatkan pengalaman visual dan suasana bagi anggota yang mengakses perpustakaan digital. Keduanya dapat dikontrol langsung dari panel Admin/Petugas.

---

## Bagian 1: Manajemen Banner

### 1.1 Apa itu Banner?

Banner adalah gambar promosi atau pengumuman berukuran besar yang tampil secara rotasi (slideshow/carousel) di halaman utama (Landing Page) atau halaman Eksplorasi Katalog. Banner digunakan untuk menyampaikan:
- Pengumuman acara perpustakaan (bedah buku, seminar, dll.)
- Promosi koleksi buku terbaru
- Informasi kebijakan perpustakaan
- Ucapan selamat hari besar

### 1.2 Cara Menambah / Mengelola Banner

1. Navigasi ke **Konten → Banner** pada panel Admin atau Petugas.
2. Klik **+ Tambah Banner Baru**.
3. Isi form:

| Field | Keterangan |
|---|---|
| Judul Banner | Teks deskriptif (untuk referensi admin, tidak ditampilkan ke publik) |
| Gambar | Upload file gambar (format: JPG/PNG/WEBP, maks. 2MB, resolusi ideal 1920×600px) |
| Link Tujuan | URL yang dituju saat banner diklik (opsional) |
| Urutan Tampil | Angka urutan di carousel (1 = tampil pertama) |
| Status | Aktif / Nonaktif |
| Periode Tayang | Tanggal mulai dan tanggal berakhir tampil (opsional, untuk banner event) |

4. Klik **Simpan**. Banner langsung aktif (jika status = Aktif).

### 1.3 Logika Rotasi Banner

Sistem menampilkan semua banner dengan `status = 'aktif'` dan `tanggal_sekarang` berada dalam rentang `periode_tayang` (jika diatur). Banner ditampilkan secara berurutan sesuai kolom `urutan` menggunakan komponen carousel Alpine.js.

```php
// Query Banner di Controller Landing Page
$banners = Banner::where('status', 'aktif')
                 ->where(function($q) {
                     $q->whereNull('tanggal_mulai')
                       ->orWhere('tanggal_mulai', '<=', now());
                 })
                 ->where(function($q) {
                     $q->whereNull('tanggal_selesai')
                       ->orWhere('tanggal_selesai', '>=', now());
                 })
                 ->orderBy('urutan')
                 ->get();
```

---

## Bagian 2: Music Player (Ambient Library Sound)

### 2.1 Apa itu Music Player?

Music Player adalah fitur _Quality-of-Life_ yang memutar musik/audio latar secara otomatis atau on-demand di halaman tertentu (misal Landing Page atau halaman katalog). Tujuannya adalah menciptakan suasana perpustakaan yang nyaman dan kondusif secara digital.

Jenis audio yang diputar biasanya berupa:
- Musik instrumental (lo-fi, klasik, jazz)
- Suara ambient perpustakaan (suara halaman buku, hujan, dll.)

### 2.2 Cara Mengelola Daftar Putar (Playlist)

1. Navigasi ke **Konten → Music Player** pada panel Admin.
2. Tambahkan lagu/audio dengan form:

| Field | Keterangan |
|---|---|
| Judul Lagu | Nama yang tampil di UI player |
| Artis | Nama artis/sumber audio |
| File Audio | Upload file (format: MP3/OGG, maks. 10MB) |
| Status | Aktif / Nonaktif |

3. Atur urutan putar dengan drag-and-drop.
4. Simpan. Music player di halaman anggota akan otomatis menggunakan daftar putar terbaru.

### 2.3 Perilaku Music Player di Sisi Anggota

- Player tampil sebagai widget mengambang kecil (floating) di pojok bawah halaman.
- **Autoplay dinonaktifkan secara default** (sesuai kebijakan browser modern yang memblokir autoplay dengan suara). Anggota harus menekan tombol Play terlebih dahulu.
- Preferensi volume dan status play/pause tersimpan di `localStorage` browser, sehingga tidak reset saat berpindah halaman dalam satu sesi.
- Anggota bisa menutup/menyembunyikan player jika tidak diinginkan.

> **Catatan teknis:** Semua file audio di-serve langsung dari server Laravel melalui path `storage/music/`. Pastikan `php artisan storage:link` sudah dijalankan agar file storage dapat diakses publik.
