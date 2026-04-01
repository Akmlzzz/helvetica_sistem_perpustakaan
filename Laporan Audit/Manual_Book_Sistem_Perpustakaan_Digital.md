# MANUAL BOOK
**SISTEM PERPUSTAKAAN DIGITAL TERINTEGRASI**
*(Midtrans Payment, AI Chatbot, Auto-Sync Spreadsheet)*

**Versi Aplikasi:** v1.0
**Logo Aplikasi:** *[Tempatkan Logo Aplikasi Anda Di Sini]*
**Nama Pembuat/Anggota Tim:** *[Nama Anda / Tim Anda]*
**Instansi:** *[Logo SMK / Nama SMK Anda]*

---
<br>

## KATA PENGANTAR

Puji syukur kami panjatkan ke hadirat Tuhan Yang Maha Esa atas terselesaikannya aplikasi **Sistem Perpustakaan Digital Terintegrasi**. Aplikasi berbasis web ini dibangun dengan tujuan untuk memodernisasi dan mendigitalisasi proses pengelolaan perpustakaan sekolah. Sistem ini dirancang untuk mengatasi masalah antrean peminjaman, pencatatan manual yang rentan hilang, serta memberikan kemudahan akses katalog buku bagi pemustaka (anggota) di mana saja. Dengan hadirnya fitur-fitur seperti sistem *booking* mandiri, pembayaran denda digital via Midtrans, asisten virtual Cendekia AI, hingga sinkronisasi data otomatis (*Auto-Sync*) ke Spreadsheet via Make.com, diharapkan sirkulasi literasi di lingkungan sekolah menjadi jauh lebih efektif, transparan, dan profesional.

---
<br>

## DAFTAR ISI

1. BAGIAN AWAL (ADMINISTRASI) .............................................................. 1
2. BAB I: PENDAHULUAN .............................................................................. 2
   - 1.1 Deskripsi Sistem .......................................................................... 2
   - 1.2 Kebutuhan Sistem (System Requirements) ................................. 3
   - 1.3 Hak Akses (Role User) ................................................................. 4
3. BAB II: PANDUAN INSTALASI & KONFIGURASI ................................... 5
4. BAB III: PANDUAN PENGGUNAAN (USER GUIDE) .............................. 7
   - 3.1 Panduan Untuk Tamu (Guest) & Pendaftaran .......................... 7
   - 3.2 Panduan Untuk Anggota (Member) ........................................... 8
   - 3.3 Panduan Untuk Petugas Pustakawan ........................................ 10
   - 3.4 Panduan Untuk Administrator ................................................... 12
5. BAB IV: TROUBLESHOOTING (PEMECAHAN MASALAH) .................... 15

---
<br>

## DAFTAR GAMBAR

- Gambar 3.1 - Halaman Utama & Akses Login Aplikasi ........................ Hal 7
- Gambar 3.2 - Dashboard Anggota dan Navigasi Menu ......................... Hal 8
- Gambar 3.3 - Memilih Buku dan Menekan Tombol Booking .............. Hal 9
- Gambar 3.4 - Halaman Proses Transaksi oleh Petugas ........................ Hal 11
- Gambar 3.5 - Menekan tombol Tambah Data Buku Baru (Admin) ....... Hal 13

---
<br>

## DAFTAR TABEL

- Tabel 1.1 - Daftar Hak Akses User .................................................... Hal 4
- Tabel 4.1 - Pemecahan Masalah (Troubleshooting) ........................... Hal 15

<br><br>

---

# BAB I: PENDAHULUAN

### 1.1 Deskripsi Sistem
**Sistem Perpustakaan Digital** adalah sistem informasi manajemen perpustakaan berbasis web (Framework Laravel) yang diciptakan untuk menyelesaikan masalah pendataan koleksi fisik, ketidakteraturan sistem antrean peminjaman, serta sulitnya menyusun laporan bulanan. Sistem ini memungkinkan Anggota untuk mencari katalog dan memesan (*booking*) buku secara daring lewat konsep keranjang (cart). Ditambah pula sistem ini telah memakai integrasi kecerdasan buatan (*Cendekia AI*) untuk asisten pencarian, *Payment Gateway* Midtrans untuk transparansi denda daring, serta integrasi webhook ke **Make.com** agar seluruh rekaman otomatis (*auto-sync*) tersimpan sebagai cadangan rapi pada dokumen Google Spreadsheet.

### 1.2 Kebutuhan Sistem (*System Requirements*)
Agar aplikasi ini dapat berjalan di server lokal atau *hosting*, diperlukan spesifikasi berikut:
**Software (Perangkat Lunak):**
- Sistem Operasi: Windows 10/11 atau macOS.
- Development Server: **Laravel Herd** (Sudah mencakup Nginx, PHP 8.2+, dan Composer).
- Database Service: **DBngin** (menjalankan *service* MySQL secara lokal).
- Database Manager: **TablePlus** (Aplikasi GUI untuk mengelola database).
- Dependency Manager: NPM (Node.js).

**Hardware (Perangkat Keras Minimal Server/Lokal):**
- CPU: Intel Core i3 / AMD Ryzen 3 atau setara.
- RAM: Minimal 4 GB.
- Penyimpanan: Ruang kosong *Harddisk/SSD* 1 GB.
- Jaringan: Koneksi internet yang stabil untuk akses Midtrans, Make.com, & API Chatbot.

### 1.3 Hak Akses (*Role User*)

Tabel di bawah menentukan batasan fungsionalitas bagi setiap aktor:

**Tabel 1.1 - Daftar Hak Akses User**
| No | Level / Hak Akses | Deskripsi Kewenangan & Fitur yang Dapat Diakses |
|----|-------------------|------------------------------------------------|
| 1  | **Guest (Tamu)** | Hanya dapat melihat Halaman Muka (Landing Page), Katalog Umum sementara, serta mengakses Halaman *Login* dan *Register*. |
| 2  | **Anggota** | Wajib login. Dapat melihat katalog rinci, melakukan pemesanan (Booking Buku), melihat riwayat pinjam, menyimpan ke daftar koleksi pribadi (*Wishlist*), menggunakan AI Chatbot, mengajukan saran buku, serta membayarkan denda keterlambatan via digital. |
| 3  | **Petugas** | Wajib login. Staf operasional yang memproses permohonan booking menjadi status "Dipinjam", serta memproses buku yang dikembalikan. Akses petugas bisa dikontrol secara mendetail oleh Admin (Contoh: Admin hanya mengizinkan Petugas A memegang kategori laporan). |
| 4  | **Administrator** | Super User. Dapat mengakses seluruh fitur: Manajemen Pengguna, Verifikasi pendaftaran anggota, mengontrol modul Data Master Buku & Kategori, menyetel Musik Latar, hingga mengelola Webhook untuk Spreadsheet, serta mencetak Laporan lengkap (PDF/Excel). |

<br><br>

---

# BAB II: PANDUAN INSTALASI & KONFIGURASI

*Catatan: Pastikan komputer telah menginstal Laravel Herd, DBngin, TablePlus, dan Node.js sebelum memulai langkah-langkah di bawah.*

1. **Persiapan Folder Aplikasi (Laravel Herd)**
   - Buka pengaturan **Laravel Herd** di tab *Paths*, pastikan direktori utama penempatan (*misal: `C:\Users\Nama\Herd`*) telah terdaftar.
   - Salin dan pindahkan folder project `sistem-perpustakaan-digital` ke dalam folder tersebut agar otomatis diarahkan oleh Herd dengan domain `.test`.
   - *(Tempatkan Gambar Screenshot Folder Herd di Sini)*

2. **Pengaturan Database (DBngin & TablePlus)**
   - Buka aplikasi **DBngin**, buat modul servis MySQL baru dan klik *Start* hingga menyala indikator hijau.
   - Buka aplikasi **TablePlus**, buat koneksi baru ke *localhost* MySQL port 3306.
   - Berikan izin koneksi lalu buat *database* baru, beri nama: `db_perpustakaan`.
   - *(Tempatkan Gambar Screenshot TablePlus di Sini: Menunjukkan proses pembuatan nama database)*

3. **Konfigurasi File Environment (.env)**
   - Buka folder aplikasi di teks editor (spt. VS Code).
   - Duplikasi file `.env.example` dan ubah namanya menjadi `.env`.
   - Buka file `.env`, sesuaikan pengaturan pada baris koneksi database:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=db_perpustakaan
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Kompilasi Modul (Via Terminal/CMD)**
   - Buka *Command Prompt* atau Terminal, arahkan ke folder proyek Anda (Misal di dalam folder Herd):  
     `cd C:\Users\NamaAnda\Herd\sistem-perpustakaan-digital`
   - Ketikkan perintah berikut stau per satu untuk menginstal *library* bawaan:
     - `composer install`
     - `npm install`
     - `npm run build`
     - `php artisan key:generate`
     - `php artisan storage:link` (Agar gambar bisa tampil)

5. **Migrasi dan Import Data Awal (.sql / Seeders)**
   - Untuk membangun tabel secara otomatis, jalankan perintah:  
     `php artisan migrate --seed`
   - *(Tempatkan Gambar Screenshot Terminal di Sini: Menunjukkan indikator tabel berhasil terbentuk)*.

6. **Menjalankan Sistem**
   - Karena Anda memakai **Laravel Herd**, Anda tidak memerlukan *command* `php artisan serve` lagi.
   - Buka browser Anda dan langsung akses domain lokal otomatis dari Herd. (Cth: `http://sistem-perpustakaan-digital.test`). Sistem siap digunakan.
   - *(Tempatkan Gambar Screenshot Layar Utama Localhost di Sini)*.

<br><br>

---

# BAB III: PANDUAN PENGGUNAAN (USER GUIDE)

### 3.1 PANDUAN UNTUK ANGGOTA (MEMBER)

Anggota adalah siswa atau pendaftar yang ingin menikmati fasilitas perpustakaan.

1. **Mendaftar dan Login**
   - Buka halaman web. Jika belum punya akun, klik tombol **Daftar/Register** di pojok kanan atas. Isikan data yang diperlukan.
   - Akun Anda perlu menunggu verifikasi Admin. Setelah aktif, masuk melalui halaman **Login** dengan kombinasi Email dan Sandi yang tepat.
   - *(Tempatkan Gambar 3.1 - Halaman Pendaftaran dan Login. Beri panah merah pada tombol 'Register')*

2. **Memproses Peminjaman (Booking)**
   - Lihat menu "Katalog Buku". Anda bisa memfilter judul lewat bilah pencarian.
   - Klik pada "Detail Buku", kemudian tekan tombol merah/biru bertuliskan **Booking / Pinjam**.
   - Sistem akan menyimpannya ke daftar pra-pinjam. Tunggu hingga statusnya divalidasi oleh petugas di lokasi.
   - *(Tempatkan Gambar 3.2 - Menekan tombol Booking di Halaman Buku)*.

3. **Membayar Denda Transaksi (Midtrans)**
   - Jika ada keterlambatan pengembalian, status denda akan muncul di **Riwayat**.
   - Klik tombol **Bayar Denda**, lalu halaman *pop-up* Midtrans akan muncul, menampilkan opsi QRIS atau bank transfer.
   - *(Tempatkan Gambar 3.3 - Jendela Pop-up Pembayaran Denda Midtrans. Beri kotak merah pada Opsi QRIS)*.

### 3.2 PANDUAN UNTUK PETUGAS PUSTAKAWAN

Petugas bertindak sebagai operator yang memvalidasi sirkulasi barang agar tertib.

1. **Memproses Pesanan Buku (Proses Booking)**
   - Setelah masuk dari antarmuka login, masuk ke menu **Proses Booking**.
   - Anda akan melihat tabel nama anggota yang sedang menunggu.
   - Cocokkan fisik barang, dan jika ada, tekan tombol hijau **Setujui Peminjaman**.
   - *(Tempatkan Gambar 3.4 - Mencentang dan Menyetujui Booking Anggota)*.

2. **Memproses Modul Pengembalian**
   - Navigasi ke menu **Pengembalian**. Cari nama/ID transaksi anggota.
   - Jika buku yang ia kembalikan telah melebih tanggal jatuh tempo, sistem akan otomatis menjumlahkan nominal denda.
   - Klik **Kembalikan**. Status akan selesai atau menggantung apabila denda harus dilunasi anggota.

### 3.3 PANDUAN UNTUK ADMINISTRATOR (BESERTA LOGIKA SISTEM)

Administrator memiliki wewenang penuh atas aplikasi. Di bagian ini, selain panduan operasional, disertakan pula penjelasan *logic* (cara kerja di balik layar) agar mudah dipahami secara arsitektur:

1. **Memverifikasi Anggota Baru**
   - **Cara Pakai:** Buka modul **Verifikasi Anggota**. Klik *Approve* pada nama anggota yang mendaftar.
   - **Logika Sistem:** Saat _Guest_ mendaftar, akunnya tersimpan di database MySQL dengan status bawaan `is_verified = false` atau `status = pending`. Sistem Laravel menahan akses login mereka lewat fitur *Middleware*. Ketika Admin menekan tombol *Approve*, *Controller* akan mengubah flag di tabel database menjadi `true`/`aktif`. Saat itulah Anggota secara sah bisa menembus verifikasi *Login Server*.
   - *(Tempatkan Gambar 3.5 - Meng-klik tombol Approve Anggota Baru)*.

2. **Manajemen Hak Akses Petugas (Role/Permission Management)**
   - **Cara Pakai:** Buka modul **Hak Akses**. Anda bisa menghidupkan (*toggle*) fitur spesifik apa saja yang boleh diakses oleh Petugas A atau Petugas B secara selektif.
   - **Logika Sistem:** Aplikasi tidak menggunakan level pengguna kaku, melainkan *Dynamic Access Control*. Saat Admin mengubah tombol *switch/toggle*, *Controller* memanipulasi rentetan perizinan yang disematkan langsung pada akun petugas tersebut. *Middleware* akan selalu mengecek perizinan spesifik (misal: `akses:denda` atau `akses:laporan`) setiap kali Petugas berpindah halaman.

3. **Manajemen Master Data Buku & Auto-Sync Webhook**
   - **Cara Pakai:** Arahkan ke menu **Katalog Buku**. Klik **Tambah Buku Baru**. Isi data (ISBN, Judul, Kategori), lalu Simpan.
   - **Logika Sistem:** Proses ini menggunakan alur 2-arah. Pertama, algoritma *Eloquent ORM* akan memvalidasi form dan menyuntikkan data ke *Database MySQL*. Kedua, jika sukses, fitur pemicu (*Trigger/Event hook*) di latar belakang (*background job*) menggunakan **Http Client** otomatis menembakkan *HTTP POST Request* bertipe JSON (*Payload*) murni menuju *URL Endpoint Webhook* milik Make.com. Make.com kemudian menerjemahkannya untuk menambah baris kosong pada *Google Spreadsheet*.

4. **Kalkulasi & Sinkronisasi Denda Cerdas (Midtrans Payment)**
   - **Cara Pakai:** Denda adalah hal mutlak yang berjalan otomatis tanpa intervensi Admin.
   - **Logika Sistem:** Setiap malam atau setiap kali buku dikembalikan, algoritma waktu (seperti *Carbon* di PHP) menghitung selisih hari antara `tanggal_jatuh_tempo` dengan `waktu_sekarang`. Apabila hasilnya *minus* (terlambat), sistem mengalikan nominal denda per hari (Misal: Rp1.000). Saat anggota menekan *Bayar Denda*, sistem melempar total rupiah dan order ID ke server **API Midtrans** memakai `Server Key`. Midtrans merespons dengan menerbitkan *Snap Token* instan yang digunakan Front-End (Javascript) untuk membuka Jendela pop-up QRIS/Transfer di layar.

5. **Mencetak & Ekspor Laporan (PDF/Excel)**
   - **Cara Pakai:** Buka modul **Laporan**. Pilih rentang tanggal transaksi, lalu klik tombol *Export*.
   - **Logika Sistem:** Fitur ini bertumpu pada *library* eksternal (seperti DomPDF atau Maatwebsite Excel). Sistem melakukan *Query Raw/Builder* ke database berdasarkan limitasi tanggal (_WhereBetween_), lalu membungkus sekumpulan baris data array (*Collection*) menjadi format tampilan HTML untuk PDF, atau dialihkan per-sel untuk ekstensi Microsoft Excel `.xlsx`. Output tersebut di-_stream_ secara langsung menjadi file unduhan statis kepada peramban (*browser*) *user*.

<br><br>

---

# BAB IV: TROUBLESHOOTING (PEMECAHAN MASALAH)

Saat menjalankan sistem, adakalanya muncul kendala internal. Tabel berikut menunjukan cara mengatasinya.

**Tabel 4.1 - Pemecahan Masalah Sistem**
| No | Jenis Masalah / Error yang Muncul | Penyebab Utama | Solusi / Cara Mengatasi |
|----|-----------------------------------|----------------|-------------------------|
| 1 | **Gagal Login / Lupa Password** | Pengguna keliru mengetik *password* atau tidak ingat sandi aslinya. | Gunakan fitur "Lupa Password" di halaman login, asalkan email aktif. Jika tidak aktif, Admin dapat masuk ke modul Pengguna (Users) dan melakukan reset (ganti) kata sandi secara manual bagi anggota tersebut. |
| 2 | **Error 500 (Internal Server) atau "SQLSTATE Connection Refused"** | Karena layanan MySQL pada aplikasi DBngin berhenti (mati) atau nama *database* di `.env` keliru. | Buka aplikasi **DBngin**, pastikan servis MySQL berstatus *Running*. Buka **TablePlus** untuk memvalidasi bahwa koneksi *database* aman. Terakhir periksa isi konfig `DB_DATABASE` pada file `.env` apakah sudah sesuai dengan yang ada di aplikasi TablePlus. |
| 3 | **Data Buku Baru / Peminjaman Tidak Masuk ke Google Spreadsheet** | Tidak adanya koneksi internet, Webhook URL Make.com kadaluarsa/salah, atau saldo _ops_ Make.com penuh. | 1. Pastikan komputer Admin memiliki internet.<br> 2. Buka _dashboard_ Make.com. Pastikan modul (*scenario*) berada pada status 'ON'.<br> 3. Cek kembali link Webhook URL, jika berubah, perbarui link _endpoint_ webhook tersebut ke konfigurasi Controller pada aplikasi Laravel Anda. |
| 4 | **Pop-up Midtrans Tidak Muncul / Gagal Bayar Denda** | Kegagalan *Server-Key* (API Key) milik Midtrans pada lingkungan pengembangan (Sandbox). | Buka akun dasbor *Midtrans Sandbox*, *copy* ulang *Client Key* dan *Server Key*. Lalu *paste* perbarui *KEY* tersebut ke file konfigurasi `.env` Laravel Anda di bagian kolom MIDTRANS. |

--- 
*Selesai. Dokumen Laporan Sistem Perpustakaan Digital Terintegrasi.*
