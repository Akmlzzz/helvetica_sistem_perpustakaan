# Laporan Sistem & Export Data (PDF / Excel)

Modul **Laporan** adalah fitur administrasi yang memungkinkan Admin dan Petugas mengunduh dan menganalisis data transaksi, keuangan, dan aktivitas perpustakaan dalam format dokumen yang siap cetak (PDF) atau siap diolah lebih lanjut (Excel/CSV).

## 1. Jenis-jenis Laporan yang Tersedia

| Jenis Laporan | Keterangan | Format |
|---|---|---|
| Laporan Peminjaman | Semua data transaksi peminjaman dalam rentang tanggal tertentu | PDF, Excel |
| Laporan Pengembalian | Data buku yang sudah dikembalikan | PDF, Excel |
| Laporan Denda | Rincian denda yang terhitung, status lunas/belum | PDF, Excel |
| Laporan Anggota Aktif | Daftar anggota beserta status dan statistik peminjaman | Excel |
| Laporan Buku Populer | Peringkat buku yang paling banyak dipinjam | PDF, Excel |
| Laporan Stok Buku | Kondisi inventaris koleksi saat ini | Excel |

---

## 2. Cara Menggunakan Fitur Laporan

1. Navigasi ke **Laporan** pada panel Admin atau Petugas.
2. Pilih **Jenis Laporan** yang diinginkan dari dropdown atau tab.
3. Tentukan **Filter Rentang Tanggal** (contoh: 1 Januari – 31 Maret 2025).
4. Filter opsional tambahan (misal: kategori buku, nama anggota tertentu, status denda).
5. Klik **Tampilkan Preview** untuk melihat data sebelum diunduh.
6. Klik **Export PDF** atau **Export Excel** untuk mengunduh file.

---

## 3. Logika Export PDF

Export PDF menggunakan library **DomPDF** (package `barryvdh/laravel-dompdf`) yang mengkonversi tampilan Blade HTML menjadi dokumen PDF.

```php
// Contoh Controller Laporan
use Barryvdh\DomPDF\Facade\Pdf;

public function exportPdf(Request $request)
{
    $data = Peminjaman::whereBetween('tgl_pinjam', [
        $request->dari,
        $request->sampai
    ])->with(['buku', 'anggota'])->get();

    $pdf = Pdf::loadView('laporan.peminjaman-pdf', compact('data'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
}
```

### Konten yang Tampil di PDF:
- Header laporan: Logo Biblio, judul laporan, tanggal cetak, dan rentang data.
- Tabel data terformat rapi.
- Footer: Nama petugas yang mencetak dan timestamp.

---

## 4. Logika Export Excel

Export Excel menggunakan library **Maatwebsite Excel** (package `maatwebsite/excel`) yang memungkinkan pembuatan file `.xlsx` yang kaya fitur.

```php
// Contoh Export Class
class PeminjamanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Peminjaman::select('id', 'nama_anggota', 'judul_buku', 'tgl_pinjam', 'tgl_jatuh_tempo', 'status')
                          ->get();
    }

    public function headings(): array
    {
        return ['No.', 'Nama Anggota', 'Judul Buku', 'Tgl Pinjam', 'Jatuh Tempo', 'Status'];
    }
}

// Di Controller:
return Excel::download(new PeminjamanExport, 'laporan-peminjaman.xlsx');
```

---

## 5. Kontrol Akses Laporan

> **Admin**: Dapat mengakses semua jenis laporan tanpa batasan.

> **Petugas**: Hanya dapat mengakses laporan yang terkait dengan tugasnya (Peminjaman, Pengembalian, Denda). Laporan sensitif seperti data keuangan komprehensif dan laporan anggota dibatasi.

Kontrol ini dikonfigurasi melalui sistem **Hak Akses Petugas** di menu Manajemen Akun (lihat: [Manajemen Pengguna](manajemen-pengguna)).

---

## 6. Tips Penggunaan

> **Tip:** Untuk laporan bulanan rutin, gunakan filter dari tanggal 1 sampai akhir bulan dengan jenis laporan "Peminjaman" + "Denda" untuk mendapatkan gambaran lengkap aktivitas sirkulasi dan pemasukan denda.
