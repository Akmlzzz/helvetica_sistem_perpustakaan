# Manajemen Pengguna & Hak Akses

Halaman ini menjelaskan cara sistem Biblio mengelola pengguna dan mengatur hak akses berbasis role.

## Struktur Pengguna

Sistem menggunakan tabel `pengguna` sebagai tabel autentikasi utama dengan kolom `level_akses`:

```sql
level_akses: 'admin' | 'petugas' | 'anggota'
```

## Menambah Pengguna Baru

1. Navigasi ke **Pengguna → Tambah Pengguna**
2. Isi form:
   - **Nama Lengkap** — nama pengguna
   - **Email** — akan digunakan sebagai username login
   - **Password** — minimal 8 karakter
   - **Level Akses** — pilih: Admin / Petugas / Anggota
3. Simpan

> **Catatan:** Hanya Admin yang dapat membuat akun Petugas dan Admin lainnya. Anggota dapat mendaftar sendiri via halaman `/register`.

## Hak Akses Petugas

Untuk akun Petugas, Admin dapat mengatur izin granular di menu **Hak Akses**. Tersedia izin berikut:

| Modul | Keterangan |
|---|---|
| `buku` | Kelola data buku & series |
| `kategori` | Kelola kategori buku |
| `peminjaman` | Proses peminjaman & pengembalian |
| `denda` | Lihat & kelola denda |
| `laporan` | Akses halaman laporan |

### Cara Mengatur Izin Petugas

1. Navigasi ke **Hak Akses**
2. Cari nama petugas
3. Toggle izin yang diperlukan
4. Perubahan tersimpan secara real-time

## Verifikasi Anggota

Anggota baru yang mendaftar perlu **diverifikasi** oleh Admin sebelum bisa menggunakan sistem penuh.

### Alur Verifikasi

```
Anggota Daftar → Status: menunggu_verifikasi
    ↓
Admin Cek di Verifikasi Anggota
    ↓
Approve / Reject
    ↓
Anggota mendapat notifikasi
```

Navigasi: **Verifikasi Anggota → Pilih Anggota → Approve**
