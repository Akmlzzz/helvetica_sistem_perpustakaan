# Kartu Anggota Digital

Fitur **Kartu Anggota Digital** adalah representasi digital dari kartu perpustakaan fisik milik setiap anggota yang terdaftar. Kartu ini dapat digunakan sebagai bukti keanggotaan saat bertransaksi di meja perpustakaan tanpa memerlukan kartu fisik.

## 1. Apa itu Kartu Anggota Digital?

Kartu Anggota Digital adalah halaman interaktif di dashboard anggota yang menampilkan informasi identitas keanggotaan secara ringkas dan terformat seperti kartu ID, dilengkapi dengan **QR Code unik** yang dapat dipindai oleh petugas untuk verifikasi cepat.

---

## 2. Informasi yang Ditampilkan pada Kartu

| Elemen | Sumber Data |
|---|---|
| Nama Lengkap | `users.name` |
| Nomor Anggota | `users.nomor_anggota` (auto-generated) |
| Foto Profil / Avatar | `users.foto` (atau inisial nama jika kosong) |
| Email | `users.email` |
| Status Keanggotaan | Aktif / Tidak Aktif berdasarkan `users.status` |
| Tanggal Bergabung | `users.created_at` |
| QR Code | Di-generate dari Nomor Anggota |

---

## 3. Logika Nomor Anggota

Setiap anggota yang berhasil mendaftar dan diverifikasi oleh Admin akan otomatis mendapatkan **Nomor Anggota** yang unik dan permanen.

### Format Nomor Anggota:
```
BIB-[TAHUN][ID USER PADDING 4 DIGIT]
Contoh: BIB-2025-0042
```

Nomor ini di-generate menggunakan observer atau event pada saat Admin menyetujui (verifikasi) pendaftaran anggota, bukan pada saat register.

---

## 4. Logika QR Code

QR Code yang tercetak pada kartu di-generate secara dinamis di sisi server menggunakan library PHP (misal: `simplesoftwareio/simple-qrcode`).

**Konten QR Code:**: Nomor anggota (`BIB-2025-0042`) atau URL verifikasi seperti `https://biblio.app/verify/member/BIB-2025-0042`.

### Alur Penggunaan QR Code di Meja Petugas:
1. Anggota membuka halaman **Kartu Anggota** di smartphone mereka.
2. Petugas menggunakan scanner QR (atau fitur scan di panel petugas).
3. Sistem langsung menampilkan profil anggota dan riwayat peminjaman aktifnya.
4. Verifikasi identitas selesai dalam hitungan detik tanpa menulis manual.

```
Anggota tunjukkan QR → Petugas scan → Sistem tampilkan profil → Transaksi diproses
```

---

## 5. Pencetakan Kartu (Print)

Anggota dapat mencetak kartu anggota digital mereka sebagai halaman terformat (PDF-friendly) dengan menekan tombol **Cetak / Download Kartu**. Tampila cetak akan menyembunyikan elemen navigasi web dan hanya menampilkan desain kartu yang bersih.

```css
/* Contoh CSS Print Media Query yang diterapkan */
@media print {
    nav, sidebar, footer { display: none; }
    .kartu-anggota { display: block; }
}
```

---

## 6. Keamanan Kartu Digital

> **QR Code tidak mengandung data sensitif** (seperti password atau token sesi). Hanya berisi nomor anggota yang pun sudah tervalidasi di database.

> **Anggota yang di-*suspend* / dinonaktifkan** akan tetap bisa mengakses halaman kartu, namun kartu akan menampilkan banner merah **"KEANGGOTAAN TIDAK AKTIF"** sehingga petugas mengetahui status tersebut saat scan.
