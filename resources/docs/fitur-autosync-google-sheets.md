# Auto-Sync Reporting (Integrasi Google Sheets)

Fitur **Auto-Sync Reporting** adalah integrasi otomatis antara Sistem Perpustakaan Digital Biblio dengan **Google Sheets** yang memungkinkan laporan transaksi perpustakaan tersinkronisasi secara real-time atau terjadwal ke dalam spreadsheet Google milik administrator, tanpa perlu proses export manual.

## 1. Konsep & Manfaat

Daripada harus download Excel setiap hari untuk memantau aktivitas, Admin dapat menghubungkan sistem ke Google Sheets sehingga data selalu up-to-date secara otomatis. Spreadsheet ini kemudian bisa:
- Dibagikan ke kepala perpustakaan via link (tanpa perlu login ke sistem).
- Diolah lebih lanjut menggunakan formula/pivot table Google Sheets.
- Dikoneksikan ke Google Looker Studio untuk visualisasi laporan yang lebih kaya.

---

## 2. Cara Kerja (Arsitektur)

```
Sistem Biblio (Laravel)
        ↓  [Triggered by Event / Scheduled Job]
Google Sheets API (via Service Account)
        ↓
Spreadsheet Google milik Admin ter-update otomatis
```

Sistem menggunakan **Google Sheets API v4** dengan autentikasi menggunakan **Service Account** (bukan OAuth user). Service Account adalah akun bot yang diberikan izin menulis ke spreadsheet tertentu tanpa harus login secara interaktif.

---

## 3. Setup Integrasi (Konfigurasi Satu Kali)

### Langkah 1: Buat Service Account di Google Cloud
1. Buka [Google Cloud Console](https://console.cloud.google.com).
2. Buat Project baru → aktifkan **Google Sheets API**.
3. Buat **Service Account** → download file kunci JSON (credential).
4. Salin email service account (format: `nama@project.iam.gserviceaccount.com`).

### Langkah 2: Siapkan Spreadsheet
1. Buat Google Spreadsheet baru.
2. **Share** spreadsheet tersebut ke email Service Account dengan izin **Editor**.
3. Catat **Spreadsheet ID** dari URL: `https://docs.google.com/spreadsheets/d/[SPREADSHEET_ID]/edit`.

### Langkah 3: Konfigurasi .env
Masukkan konfigurasi berikut ke file `.env`:

```dotenv
GOOGLE_SERVICE_ACCOUNT_JSON=/path/ke/credentials.json
GOOGLE_SHEETS_SPREADSHEET_ID=1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgVE2upms
```

---

## 4. Data yang Disinkronisasi

Sinkronisasi menulis ke beberapa **Sheet (tab)** dalam satu Spreadsheet:

| Nama Sheet | Data yang Ditulis | Frekuensi Sync |
|---|---|---|
| `Peminjaman` | Semua record peminjaman aktif & histori | Setiap ada transaksi baru |
| `Denda` | Semua record denda beserta statusnya | Setiap ada perubahan status denda |
| `Anggota` | Daftar anggota aktif | Harian (setiap tengah malam) |
| `Ringkasan` | Statistik agregat (total buku, anggota, dll.) | Setiap jam |

---

## 5. Mekanisme Sync: Event vs Scheduled

Sistem mendukung dua metode sinkronisasi:

### a. Event-based (Real-time Sync)
Setiap kali ada transaksi penting (peminjaman baru, denda lunas, dll.), sistem menembakkan sebuah Laravel **Event** yang didengarkan oleh **Listener** yang bertugas menulis ke Google Sheets.

```php
// Contoh: setelah denda lunas, otomatis update Sheet
event(new DendaLunas($denda));

// Listener: App\Listeners\SyncDendaToSheets
public function handle(DendaLunas $event)
{
    GoogleSheetsService::updateRow('Denda', $event->denda);
}
```

### b. Scheduled Job (Sinkronisasi Terjadwal)
Untuk sinkronisasi massal harian/jamuan, sistem menggunakan Laravel **Scheduler** yang berjalan via cronjob server.

```php
// routes/console.php
Schedule::command('sheets:sync-all')->daily()->at('23:59');
Schedule::command('sheets:sync-ringkasan')->hourly();
```

> **Perlu Konfigurasi Server:** Pastikan cronjob `* * * * * php /path/to/artisan schedule:run` sudah aktif di server hosting/VPS agar Schedule berjalan otomatis.

---

## 6. Troubleshooting Umum

| Masalah | Kemungkinan Penyebab | Solusi |
|---|---|---|
| Data tidak muncul di Sheet | Service Account belum di-share ke Spreadsheet | Share ulang spreadsheet ke email SA dengan izin Editor |
| Error "403 Forbidden" | Spreadsheet ID salah atau API belum diaktifkan | Cek `GOOGLE_SHEETS_SPREADSHEET_ID` di `.env` |
| Sync tidak berjalan otomatis | Cronjob tidak aktif di server | Jalankan `php artisan schedule:run` manual, atau periksa konfigurasi cron |
| Credential file tidak ditemukan | Path di `.env` salah | Pastikan path file JSON mutlak dan dapat dibaca Laravel |
