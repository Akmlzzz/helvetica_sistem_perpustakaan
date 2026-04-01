# Logika Autentikasi & Hak Akses (Role-Based Access Control)

Sistem Perpustakaan Digital Biblio menggunakan **Role-Based Access Control (RBAC)** untuk memastikan setiap tipe pengguna (User) hanya dapat mengakses menu dan aksi yang diizinkan untuk tingkatan mereka.

## 1. Tiga Role Utama

Dalam sistem Biblio, terdapat tiga level akses yang direpresentasikan melalui atribut `role` pada tabel `users`:

- **Admin (`admin`)**: Memiliki hak prerogatif tertinggi di sistem. Mengakses dashboard admin yang berisi pengelolaan pengguna lengkap, master kategori buku, master rak, persetujuan pendaftaran (opsional), pengaturan sistem, dan laporan komprehensif.
- **Petugas (`petugas`)**: Mengelola sirkulasi harian perpustakaan. Mengakses daftar anggota, inventaris buku masuk, sirkulasi peminjaman menuggu konfirmasi, denda berjalan, pengembalian, dan laporan sirkulasi sederhana.
- **Anggota (`anggota`)**: Publik atau perwakilan organisasi yang menggunakan perpustakaan untuk meminjam buku, mengeksplorasi katalog, memantau riwayat peminjaman, serta membayar denda atas keterlambatan.

## 2. Alur Login (Autentikasi Multiple Role)

### Logika Saat "Sign In":
1. Pengguna memasukkan **Email** atau **Username** dan **Password** di halaman login (`/login`).
2. `AuthController@authenticate` divalidasi oleh framework *Laravel Session Guard*.
3. Jika kredensial (username/password) cocok dengan database:
   - Laravel me-regenerate session (menghindari session fixation).
   - Pengguna berhasil sign in.
4. **Validasi Role untuk Redirect**:
   Sistem mengevaluasi nilai `auth()->user()->role`:
   - Jika `role == 'admin'`, sistem melakukan redirect (arahan otomatis) ke rute `/admin/dashboard`.
   - Jika `role == 'petugas'`, sistem melakukan redirect ke rute `/petugas/dashboard`.
   - Jika `role == 'anggota'`, sistem melakukan redirect ke rute `/anggota/dashboard` (atau langsung ke home / eksplor katalog).

## 3. Middleware Role-Check (Pembatasan Route Akses)

Untuk mencegah pengguna mengakses rute atau dashboard yang bukan miliknya dengan mengetik URL secara manual (contoh: Anggota mengetik manual URL `/admin/dashboard` meskipun bukan Admin), sistem memberlakukan lapisan keamanan Middleware.

### Implementasi Middleware (RoleMiddleware)

- Jika rute digrup menggunakan `middleware(['auth', 'role:admin'])`:
  Sistem mengecek: "Apakah sesi ada? Apakah role = admin?". Jika tidak, pengguna akan dilempar (*redirect*) paksa ke dashboard aslinya atau ke halaman error 403 Forbidden.

### Keuntungan Pembatasan:
- **Zero-Trust**: Mencegah kebocoran data anggota atau stok jika URL dibagikan atau dieksploitasi oleh pengunjung yang tidak memiliki hak `petugas/admin`.

## 4. Keamanan Pendaftaran Anggota

Pendaftaran pengguna dibatasi dengan logika:
- **Register Eksternal**: Hanya dapat membuat akun baru dengan `role` otomatis terseting menjadi `anggota`. Halaman registrasi publik tidak dapat digunakan untuk mendaftar sebagai *Admin* maupun *Petugas*.
- **Admin & Petugas Baru**: Pembuatan akun untuk staf baru hanya dapat dilakukan dari dalam menu **Manajemen Pengguna** oleh relasi yang sudah berstatus `Admin` (Super User).

## 5. Fitur "Ingat Saya" (Remember Token)

Sistem login mendukung *Remember Me Cookie* jika diaktifkan. Di mana Laravel menyimpan UUID unik terenkripsi agar pengguna tidak perlu terus-menerus sign-in selama X hari ke depan setiap browser ditutup (diatur dalam `config/session.php`). Cookie tersebut akan invalid (_expired_) saat User menekan tombol "Logout".
