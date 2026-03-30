# Manajemen Buku & Series

Halaman ini menjelaskan cara mengelola koleksi buku dan series (serial buku) di dalam sistem Biblio.

## Menambahkan Buku Baru

### Via Form Satuan

Navigasi ke **Buku → Tambah Buku** untuk menambahkan satu buku secara manual.

Field yang wajib diisi:

| Field | Tipe | Keterangan |
|---|---|---|
| Judul | Text | Judul lengkap buku |
| Pengarang | Text | Nama penulis |
| Penerbit | Text | Nama penerbit |
| Tahun Terbit | Angka | Tahun publikasi |
| Stok | Angka | Jumlah eksemplar tersedia |
| Kategori | Dropdown | Pilih dari kategori yang ada |
| ISBN | Text (opsional) | Nomor ISBN 13 digit |
| Cover | File (opsional) | Gambar sampul buku |

### Via Batch (Massal)

Fitur batch memungkinkan admin menginput banyak buku sekaligus menggunakan format tabel.

```
Navigasi: Admin → Buku → Input Batch
```

**Langkah-langkah:**
1. Klik tombol **+ Tambah Baris** untuk setiap buku
2. Isi kolom: Judul, Pengarang, Kategori, Stok
3. Klik **Simpan Semua** untuk menyimpan batch

> **Tip:** Gunakan fitur batch saat menerima koleksi buku baru dalam jumlah besar untuk menghemat waktu.

## Mengelola Series Buku

Series digunakan untuk mengelompokkan buku-buku yang merupakan bagian dari satu serial (misal: Harry Potter Vol. 1, 2, 3).

### Membuat Series Baru

1. Navigasi ke **Buku → Series**
2. Klik **Buat Series Baru**
3. Isi nama series dan deskripsi
4. Simpan

### Menambahkan Buku ke Series

**Cara 1 — Saat input buku:**
- Pada form tambah/edit buku, pilih series dari dropdown **"Masuk ke Series"**

**Cara 2 — Via Batch Series:**
1. Navigasi ke **Buku → Input Batch**
2. Scroll ke bagian **"Assign Series ke Buku yang Ada"**
3. Pilih series target, centang buku-buku yang akan dimasukkan
4. Klik **Assign ke Series**

**Cara 3 — Pindah antar Series:**
1. Di halaman Batch, cari bagian **"Pindahkan Buku Antar Series"**
2. Pilih series asal (filter otomatis menampilkan buku)
3. Centang buku yang akan dipindah
4. Pilih series tujuan → klik **Pindahkan**

## Status Buku

Setiap buku memiliki status yang menentukan ketersediaannya:

| Status | Keterangan |
|---|---|
| `tersedia` | Buku dapat dipinjam oleh anggota |
| `booking` | Buku sedang dibooking, belum diserahkan |
| `dipinjam` | Buku sedang dipinjam oleh anggota |
| `terlambat` | Buku melewati tanggal jatuh tempo |

## Pencarian & Filter Buku

Di halaman daftar buku (admin), tersedia filter:
- **Judul / Pengarang** — pencarian teks bebas
- **Kategori** — filter berdasarkan kategori
- **Status** — filter berdasarkan status buku
- **Series** — tampilkan hanya buku dalam series tertentu

## Menghapus Buku

> **Peringatan:** Buku yang sedang dalam status `dipinjam` atau `booking` **tidak dapat dihapus**. Selesaikan transaksi terlebih dahulu.

Untuk menghapus buku:
1. Buka detail buku di **Buku → [nama buku]**
2. Klik tombol **Hapus**
3. Konfirmasi pada dialog yang muncul

## Model Database Buku

```php
// App\Models\Buku
protected $fillable = [
    'judul', 'pengarang', 'penerbit', 'tahun_terbit',
    'isbn', 'stok', 'id_kategori', 'id_series',
    'nomor_urut_series', 'cover', 'status', 'deskripsi'
];

// Relasi
public function kategori(): BelongsTo
public function series(): BelongsTo
public function peminjaman(): HasMany
public function ulasan(): HasMany
```
