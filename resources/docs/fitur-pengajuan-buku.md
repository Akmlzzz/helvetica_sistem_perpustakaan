# Fitur Pengajuan / Usulan Buku Baru

Sistem **Pengajuan Buku** (atau Usulan Buku) adalah fitur partisipatif yang memungkinkan anggota perpustakaan untuk secara aktif berkontribusi dalam pengembangan koleksi dengan mengajukan judul buku yang ingin mereka baca namun belum tersedia di perpustakaan.

## 1. Konsep Dasar

Anggota mengisi form usulan berisi informasi buku yang diinginkan. Usulan tersebut masuk ke antrian di panel Admin/Petugas untuk dikaji, kemudian diputuskan apakah buku tersebut akan dibeli/diadakan atau ditolak. Fitur ini menjembatani kebutuhan anggota dengan kurator koleksi perpustakaan.

---

## 2. Cara Mengajukan Buku (Sisi Anggota)

1. Login → Buka menu **Usulkan Buku** di dashboard anggota.
2. Isi form usulan:

| Field | Keterangan |
|---|---|
| Judul Buku | Judul buku yang diinginkan (wajib) |
| Pengarang | Nama penulis (opsional, membantu pencarian) |
| Penerbit | Nama penerbit (opsional) |
| ISBN | Nomor ISBN jika diketahui (opsional) |
| Alasan/Catatan | Mengapa buku ini perlu diadakan |

3. Klik **Ajukan** → Sistem menyimpan pengajuan dengan status `menunggu`.
4. Anggota dapat melihat daftar pengajuan mereka dan statusnya di menu **Pengajuan Saya**.

---

## 3. Alur Status Pengajuan

```
Anggota Submit
      ↓
Status: menunggu
      ↓
Admin/Petugas Tinjau
      ↓
   ┌────────────────┐
   │                │
Disetujui        Ditolak
(diproses)       (ditolak)
   │
   ↓
Buku diadakan → ditambahkan ke katalog
```

| Status | Keterangan |
|---|---|
| `menunggu` | Baru diajukan, belum ditinjau |
| `diproses` | Disetujui, sedang dalam proses pengadaan |
| `ditolak` | Tidak bisa dipenuhi (alasan dapat ditulis admin) |
| `tersedia` | Buku sudah tersedia di katalog |

---

## 4. Pengelolaan Usulan (Sisi Admin/Petugas)

Admin dan Petugas yang memiliki izin dapat mengakses daftar semua usulan masuk di menu **Pengajuan Buku** pada panel mereka.

### Aksi yang Tersedia:
- **Setujui (Proses)**: Menandai usulan sedang ditindaklanjuti. Dapat ditambahkan catatan balasan ke anggota.
- **Tolak**: Menolak usulan. Admin/Petugas wajib mengisi alasan penolakan yang akan dilihat anggota.
- **Filter & Cari**: Memfilter usulan berdasarkan status atau kata kunci judul buku.

---

## 5. Aturan Bisnis Penting

> **Anti-Duplikasi:** Sistem mengecek apakah buku dengan judul serupa sudah ada di katalog sebelum menyimpan pengajuan, dan memberikan saran ke anggota jika buku sudah tersedia.

> **Batas Pengajuan:** Satu anggota hanya dapat memiliki maksimal **3 pengajuan aktif (status `menunggu`)** secara bersamaan untuk mencegah spam usulan.
