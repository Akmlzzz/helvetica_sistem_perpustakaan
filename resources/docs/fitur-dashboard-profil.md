# Dashboard Ringkasan & Profil Pengguna

Halaman **Dashboard** adalah tampilan utama yang pertama kali dilihat pengguna setelah login. Setiap role memiliki tampilan dashboard yang berbeda, disesuaikan dengan konteks kebutuhan mereka.

---

## 1. Dashboard Anggota

Dashboard anggota dirancang sebagai pusat aktivitas personal yang memberikan ringkasan cepat tentang status keanggotaan dan transaksi terkini.

### Elemen yang Ditampilkan:

| Widget | Data yang Ditampilkan |
|---|---|
| **Kartu Sambutan** | Salam personal dengan nama anggota dan foto profil |
| **Pinjaman Aktif** | Jumlah buku yang sedang dipinjam + info jatuh tempo terdekat |
| **Notifikasi Denda** | Peringatan jika ada denda yang belum dilunasi (dengan jumlahnya) |
| **Buku Waiting Konfirmasi** | Jumlah booking yang masih menunggu diproses petugas |
| **Riwayat Terakhir** | 3-5 transaksi peminjaman terbaru |
| **Rekomendasi Buku** | Buku populer atau berdasarkan kategori favorit anggota |

### Logika Notifikasi Denda:
Jika `Denda::where('id_anggota', auth()->id())->where('status_denda', 'belum_lunas')->exists()` bernilai `true`, sistem menampilkan banner peringatan berwarna merah/oranye di bagian atas dashboard dengan tautan langsung ke halaman pembayaran.

---

## 2. Dashboard Petugas

Dashboard petugas berfokus pada **antrian kerja** yang perlu ditindaklanjuti segera.

### Widget Utama:

| Widget | Data |
|---|---|
| **Menunggu Konfirmasi** | Jumlah booking yang perlu disetujui hari ini |
| **Jatuh Tempo Hari Ini** | Buku yang harus dikembalikan hari ini |
| **Terlambat** | Jumlah buku yang melewati jatuh tempo (perlu ditagih dendanya) |
| **Pengembalian Hari Ini** | Jumlah buku yang sudah dikembalikan hari ini |
| **Verifikasi Anggota** | Jumlah pendaftar anggota baru yang menunggu verifikasi |

---

## 3. Dashboard Admin

Dashboard admin memberikan **gambaran menyeluruh** sistem dari perspektif manajerial.

### Statistik Real-Time (Metric Cards):

| Metrik | Keterangan |
|---|---|
| Total Buku | Total judul unik di katalog |
| Total Anggota Aktif | Anggota yang sudah terverifikasi |
| Peminjaman Aktif | Buku yang sedang dipinjam saat ini |
| Total Denda Pending | Akumulasi nilai denda yang belum terbayar (Rp) |

### Grafik & Visualisasi:
- **Grafik Peminjaman Mingguan**: Chart garis/batang yang menampilkan tren jumlah peminjaman selama 7 hari terakhir.
- **Distribusi Kategori Buku**: Pie chart proporsi koleksi per kategori.
- **Top 5 Buku Terpopuler**: Buku dengan jumlah peminjaman tertinggi bulan ini.

### Logika Pengambilan Data Grafik:
```php
// Peminjaman per hari untuk 7 hari terakhir
$data = Peminjaman::selectRaw('DATE(tgl_pinjam) as tanggal, COUNT(*) as total')
    ->where('tgl_pinjam', '>=', now()->subDays(7))
    ->groupBy('tanggal')
    ->orderBy('tanggal')
    ->get();
```

---

## 4. Halaman Profil & Pengaturan Akun

Selain dashboard, setiap pengguna (semua role) dapat mengakses halaman **Profil** untuk mengelola data akun pribadi mereka.

### Fitur yang Tersedia di Halaman Profil:

| Fitur | Keterangan |
|---|---|
| **Edit Nama & Email** | Perubahan nama tampilan dan email login |
| **Ganti Foto Profil** | Upload foto baru (format JPG/PNG, maks. 1MB) |
| **Ganti Password** | Memerlukan konfirmasi password lama |
| **Informasi Keanggotaan** | Tampilkan nomor anggota dan status verifikasi (khusus anggota) |

### Validasi Ganti Password:
```php
$request->validate([
    'password_lama'          => 'required',
    'password_baru'          => 'required|min:8|confirmed',
    'password_baru_confirmation' => 'required',
]);

// Cek password lama sebelum update
if (!Hash::check($request->password_lama, auth()->user()->password)) {
    return back()->withErrors(['password_lama' => 'Password lama tidak cocok.']);
}
```
