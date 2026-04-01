# Fitur Perpanjangan Durasi Pinjaman

Fitur **Perpanjangan** memungkinkan anggota mendapatkan tambahan waktu peminjaman tanpa harus mengembalikan buku terlebih dahulu ke perpustakaan, memberikan fleksibilitas lebih dalam proses peminjaman.

## 1. Konsep Dasar

Perpanjangan adalah mekanisme di mana `tgl_jatuh_tempo` pada sebuah record peminjaman yang sedang aktif **digeser maju** sejumlah hari tertentu (biasanya setara dengan durasi peminjaman default, yaitu 7 hari).

```
Jatuh Tempo Lama  : 8 Maret 2025
Perpanjangan +7   : 15 Maret 2025
Jatuh Tempo Baru  : 15 Maret 2025
```

---

## 2. Syarat & Batasan Perpanjangan

Tidak semua buku/peminjaman bisa diperpanjang. Sistem menerapkan aturan berikut:

| Kondisi | Boleh Diperpanjang? |
|---|---|
| Status peminjaman `dipinjam` | ✅ Ya |
| Status peminjaman `terlambat` | ❌ **Tidak**. Harus dikembalikan dulu dan lunasi denda. |
| Sudah pernah diperpanjang sebelumnya | ❌ **Tidak**. Setiap peminjaman hanya boleh diperpanjang **1 kali**. |
| Anggota memiliki denda aktif (belum lunas) | ❌ **Tidak**, sistem akan memblokir aksi perpanjangan. |

> **Logika Kunci:** Kolom `is_extended` (boolean) pada tabel `peminjaman` digunakan sebagai penjaga (guard). Saat perpanjangan berhasil, nilainya diubah dari `false` menjadi `true` sehingga tidak bisa diperpanjang lagi.

---

## 3. Cara Perpanjangan (dari Sisi Anggota)

1. Login ke akun anggota → buka menu **Pinjaman Saya**.
2. Temukan buku yang masih aktif (status `dipinjam`).
3. Klik tombol **Perpanjang** di sebelah buku tersebut.
4. Sistem secara otomatis memvalidasi semua syarat di atas.
5. Jika valid, `tgl_jatuh_tempo` langsung diperbarui dan anggota melihat tanggal baru.

---

## 4. Implementasi Logika di Controller

```php
// AnggotaController@perpanjang
public function perpanjang($id_peminjaman)
{
    $peminjaman = Peminjaman::findOrFail($id_peminjaman);

    // Guard 1: pastikan milik anggota yang login
    abort_if($peminjaman->id_anggota !== auth()->id(), 403);

    // Guard 2: status harus 'dipinjam'
    abort_if($peminjaman->status !== 'dipinjam', 422, 'Status tidak valid untuk diperpanjang.');

    // Guard 3: belum pernah diperpanjang
    abort_if($peminjaman->is_extended, 422, 'Peminjaman ini sudah pernah diperpanjang.');

    // Guard 4: tidak ada denda aktif
    $dendaAktif = Denda::where('id_anggota', auth()->id())
                       ->where('status_denda', 'belum_lunas')
                       ->exists();
    abort_if($dendaAktif, 422, 'Lunasi denda terlebih dahulu sebelum memperpanjang.');

    // Proses perpanjangan
    $peminjaman->update([
        'tgl_jatuh_tempo' => Carbon::parse($peminjaman->tgl_jatuh_tempo)->addDays(7),
        'is_extended'     => true,
    ]);

    return back()->with('success', 'Peminjaman berhasil diperpanjang!');
}
```

---

## 5. Diagram Alur Perpanjangan

```
Anggota klik "Perpanjang"
        ↓
[Cek: status == 'dipinjam'?]
    Tidak → Tampilkan error "Buku sudah terlambat, harap kembalikan"
    Ya  ↓
[Cek: is_extended == false?]
    Tidak → Tampilkan error "Hanya 1x perpanjangan diizinkan"
    Ya  ↓
[Cek: tidak ada denda aktif?]
    Ada → Tampilkan error "Lunasi denda dulu"
    Tidak ada ↓
Update tgl_jatuh_tempo += 7 hari
Set is_extended = true
        ↓
Notifikasi sukses ke Anggota
```
