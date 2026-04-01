# Logika Pembayaran & Denda Otomatis

Dokumen ini menjelaskan secara lengkap cara sistem Biblio menghitung dan memproses denda keterlambatan pengembalian buku.

## Konsep Dasar

Denda dikenakan ketika seorang anggota tidak mengembalikan buku sebelum atau pada **tanggal jatuh tempo** (`tgl_jatuh_tempo`).

**Formula Denda:**
```
Total Denda = Jumlah Hari Keterlambatan × Tarif Denda Per Hari
```

> Tarif denda default adalah **Rp 1.000 per hari** per buku. Nilai ini dapat dikonfigurasi di `config/app.php` atau melalui environment variable `DENDA_PER_HARI`.

## Alur Peminjaman & Denda

```
Anggota Booking
     ↓
Petugas Konfirmasi (status: dipinjam, tgl_pinjam & tgl_jatuh_tempo diset)
     ↓
Masa Pinjam Aktif (7-14 hari, tergantung konfigurasi)
     ↓
[Jika melewati tgl_jatuh_tempo] → Status: terlambat
     ↓
Anggota Kembalikan Buku
     ↓
Sistem Hitung Denda → Record di tabel `denda`
     ↓
Anggota Bayar Denda (via Midtrans / tunai)
     ↓
Status Denda: lunas
```

## Detail Perhitungan

### Kapan Denda Dihitung?

Denda dihitung **pada saat pengembalian buku** oleh petugas. Sistem secara otomatis:

1. Mengambil `tgl_jatuh_tempo` dari record peminjaman
2. Membandingkan dengan tanggal hari ini (`Carbon::today()`)
3. Jika `hari_ini > tgl_jatuh_tempo`, maka ada keterlambatan

### Contoh Perhitungan

```
Tanggal Pinjam   : 1 Maret 2025
Tanggal Jatuh Tempo : 8 Maret 2025 (7 hari masa pinjam)
Tanggal Kembali  : 15 Maret 2025

Keterlambatan    : 15 - 8 = 7 hari
Total Denda      : 7 × Rp 1.000 = Rp 7.000
```

### Implementasi di Controller

```php
// PetugasController@returnBuku
$tglKembali = Carbon::today();
$tglJatuhTempo = Carbon::parse($peminjaman->tgl_jatuh_tempo);

if ($tglKembali->gt($tglJatuhTempo)) {
    $hariTerlambat = $tglJatuhTempo->diffInDays($tglKembali);
    $dendaPerHari = config('app.denda_per_hari', 1000);
    $totalDenda = $hariTerlambat * $dendaPerHari;

    Denda::create([
        'id_peminjaman' => $peminjaman->id_peminjaman,
        'jumlah_hari'   => $hariTerlambat,
        'jumlah_denda'  => $totalDenda,
        'status_denda'  => 'belum_lunas',
    ]);
}
```

## Status Denda

| Status | Keterangan |
|---|---|
| `belum_lunas` | Denda sudah dihitung, belum dibayar |
| `menunggu_konfirmasi` | Pembayaran diproses via Midtrans |
| `lunas` | Denda sudah terbayar |

## Sistem Pembayaran Denda (Midtrans)

Anggota dapat membayar denda secara online melalui integrasi **Midtrans Snap**.

### Alur Pembayaran Online

1. Anggota login → buka halaman **"Pinjaman Saya"**
2. Jika ada denda, muncul tombol **"Bayar Sekarang"**
3. Sistem memanggil `PaymentController@createSnapToken`
4. Midtrans Snap pop-up terbuka → Anggota pilih metode bayar
5. Setelah sukses, Midtrans callback ke `/payment/midtrans/callback`
6. Sistem update status denda menjadi `lunas`

### Environment Variables yang Diperlukan

Pastikan variabel ini sudah diset di `.env`:

```dotenv
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false   # Ganti true saat production
```

## Notifikasi Keterlambatan

Sistem mengirimkan notifikasi **in-app** ke anggota ketika:
- Buku melewati tanggal jatuh tempo (cek via scheduled command)
- Denda baru dibuat setelah pengembalian
- Pembayaran berhasil dikonfirmasi

### Scheduled Command

```php
// routes/console.php
Schedule::command('denda:cek-keterlambatan')->daily();
```

## Aturan Bisnis Penting

> **Buku dengan status `terlambat` tidak dapat diperpanjang.** Anggota harus mengembalikan dan melunasi denda terlebih dahulu.

> **Anggota dengan denda belum lunas tidak dapat melakukan booking baru.** Sistem akan memblokir permintaan booking jika ada denda aktif.

> **Pembatalan booking** sebelum buku diserahkan tidak dikenakan denda.
