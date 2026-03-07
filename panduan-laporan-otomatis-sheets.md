# Panduan Lengkap Laporan Otomatis Terpisah ke Google Sheets

## Tujuan

Sistem ini menggunakan kecerdasan **Laravel Observers** dan **Make.com Router**. Tujuannya adalah untuk mencatat aktivitas perpustakaan secara otomatis tanpa Anda perlu menekan tombol apapun.

Sistem ini bisa mendeteksi 2 hal dan **memisahkan catatannya ke tabel (Sheet) yang berbeda**:

1. Saat ada **Peminjaman Buku Baru** atau **Pengembalian Buku**.
2. Saat ada **Buku Baru** yang ditambahkan ke perpustakaan.

---

## Langkah 1: Persiapan di Google Sheets

1. Buka [Google Sheets](https://docs.google.com/spreadsheets).
2. Buat spreadsheet baru, misalnya beri nama **Laporan Otomatis Perpustakaan**.
3. Di bagian bawah layar, buatlah **2 Tab (Sheet) terpisah**:

    **Sheet 1: Beri nama "Peminjaman"**
    Buat Header di baris pertama (A-F):
    - Waktu Update
    - Jenis Aktivitas
    - Kode Booking
    - Nama Anggota
    - Judul Buku
    - Status Transaksi

    **Sheet 2: Beri nama "Buku"**
    Buat Header di baris pertama (A-E):
    - Waktu Update
    - Jenis Aktivitas
    - Judul Buku
    - Penulis
    - Stok

---

## Langkah 2: Persiapan di Make.com (Bagian Webhook)

1. Login ke [Make.com](https://make.com) dan buat skenario baru (Create a new scenario).
2. Tambahkan module **Webhooks > Custom Webhook**.
3. Klik **Add**, beri nama (misal: "Webhook Laporan Perpustakaan").
4. **Salin (Copy) URL yang muncul**, lalu klik **OK**. URL ini adalah "corong" utama Anda.
5. Klik kanan pada garis/titik di sebelah Webhook, pilih **Add a module**, lalu cari ikon **Flow Control** (berwarna hijau) > Pilih **Router**.
   Router ini akan memisahkan jalan data Anda ke jalur Excel yang benar.

---

## Langkah 3: Tempelkan URL ke Kode Laravel

Karena sistem kodenya sudah dibuatkan sebelumnya (Observer), Anda hanya perlu memasukkan URL hasil kopi (Langkah 2) ke 2 file ini:

1. **Buka File `app/Observers/PeminjamanObserver.php`**
    - Cari baris kode `$webhookUrl = 'GANTI_DENGAN_URL_WEBHOOK_YANG_BARU_DISINI';` (sekitar baris 12-13).
    - Ganti isi tulisan tersebut dengan URL Webhook milik Anda (jangan hilangkan tanda kutipnya).
    - Save file.

2. **Buka File `app/Observers/BukuObserver.php`**
    - Lakukan hal yang sama, ganti `$webhookUrl = 'GANTI_DENGAN_URL_WEBHOOK_YANG_BARU_DISINI';` menjadi URL webhook Anda.
    - Save file.

---

## Langkah 4: Tes Kirim Data & Pemetaan (Routing Make.com)

Sekarang saatnya memasang jalur pipa pencatatan Excelnya!

1. **Jalankan Skenario Sementara:** Di pojok kiri bawah Make.com, klik **Run once**.
2. **Pancing Data:** Buka aplikasi website perpustakaan Anda, lalu cobalah **tambahkan 1 buku baru** dan buatlah **1 peminjaman baru** (agar webhook menerima data contoh).
3. **Atur Jalur 1 (Untuk Peminjaman):**
    - Klik pada "cabang atas" dari Router, tambahkan module **Google Sheets > Add a Row**.
    - Pilih akun Google Anda dan pilih file spreadsheet **Laporan Otomatis Perpustakaan**.
    - Pada kolom `Sheet`, pilih **Peminjaman**. Petakan isian form dengan data variabel dari webhook yang bertuliskan nama yang sama.
    - **(PENTING!) Atur Filter:** Klik logo tanda kunci obeng (filter) di garis penghubung antara Router dan Google Sheets jalur atas.
        - Kolom `Condition`: pilih variabel webhook **`jenis_tabel`**.
        - Pilihan tengah dropdown: `Equal to`.
        - Kolom isian bawah: ketik manual tulisan `tabel_peminjaman`.
        - Klik OK.

4. **Atur Jalur 2 (Untuk Buku):**
    - Klik pada "cabang bawah" dari Router, tambahkan module **Google Sheets > Add a Row**.
    - Pilih akun Google dan file yang sama, tapi kolom `Sheet`-nya pilih **Buku**.
    - Petakan form dengan variabel webhook.
    - **(PENTING!) Atur Filter:** Klik ikon filter di garis penghubung jalur bawah.
        - Kolom `Condition`: pilih variabel **`jenis_tabel`**.
        - Pilihan tengah: `Equal to`.
        - Kolom isian bawah: ketik manual tulisan `tabel_buku`.
        - Klik OK.

---

## Langkah 5: Finising

Jika semuanya selesai, pastikan Anda menekan tombol **Save (Gambar Disket)** di Make.com dan mengubah tombol "Scheduling" menjadi status **ON**.

Selesai! Mulai saat ini, setiap staf/admin perpustakaan mendaftarkan buku atau melayani peminjaman, Google Sheets akan langsung secara ajaib mencatatnya secara detail di tab (`Sheet`) yang diinstruksikan.
