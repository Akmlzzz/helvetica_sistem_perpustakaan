<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Pengguna;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Denda;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori
        $kategoriNames = ['Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Seni'];
        foreach ($kategoriNames as $name) {
            Kategori::updateOrCreate(['nama_kategori' => $name]);
        }
        $kategoriIds = Kategori::pluck('id_kategori')->toArray();

        // 2. Buku
        $bukuData = [
            ['judul_buku' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'stok' => 10],
            ['judul_buku' => 'Bumi', 'penulis' => 'Tere Liye', 'stok' => 5],
            ['judul_buku' => 'Sapiens', 'penulis' => 'Yuval Noah Harari', 'stok' => 3],
            ['judul_buku' => 'Clean Code', 'penulis' => 'Robert C. Martin', 'stok' => 7],
            ['judul_buku' => 'The Design of Everyday Things', 'penulis' => 'Don Norman', 'stok' => 4],
        ];

        foreach ($bukuData as $index => $data) {
            Buku::updateOrCreate(
                ['judul_buku' => $data['judul_buku']],
                [
                    'isbn' => '978-' . rand(1000, 9999),
                    'penulis' => $data['penulis'],
                    'penerbit' => 'Penerbit ' . ($index + 1),
                    'stok' => $data['stok'],
                    'id_kategori' => $kategoriIds[array_rand($kategoriIds)],
                ]
            );
        }
        $bukuIds = Buku::pluck('id_buku')->toArray();

        // 3. Pengguna & Anggota
        for ($i = 1; $i <= 5; $i++) {
            $email = "user$i@example.com";
            $pengguna = Pengguna::updateOrCreate(
                ['email' => $email],
                [
                    'nama_pengguna' => "User $i",
                    'kata_sandi' => Hash::make('password123'),
                    'level_akses' => 'anggota',
                ]
            );

            Anggota::updateOrCreate(
                ['id_pengguna' => $pengguna->id_pengguna],
                [
                    'nama_lengkap' => "Nama Lengkap User $i",
                    'alamat' => "Alamat Jalan No. $i",
                    'nomor_telepon' => "0812345678$i",
                ]
            );
        }
        $penggunaIds = Pengguna::where('level_akses', 'anggota')->pluck('id_pengguna')->toArray();

        // 4. Peminjaman
        $statuses = ['dipinjam', 'dikembalikan', 'terlambat'];
        for ($i = 1; $i <= 10; $i++) {
            $tglPinjam = Carbon::now()->subDays(rand(1, 30))->toDateString();
            $status = $statuses[array_rand($statuses)];
            $tglKembali = ($status == 'dikembalikan') ? Carbon::parse($tglPinjam)->addDays(rand(3, 10))->toDateString() : null;

            $randomBukuId = $bukuIds[array_rand($bukuIds)];

            $peminjaman = Peminjaman::create([
                'id_pengguna' => $penggunaIds[array_rand($penggunaIds)],
                'id_buku' => $randomBukuId,
                'tgl_pinjam' => $tglPinjam,
                'tgl_kembali' => $tglKembali,
                'status_transaksi' => $status,
            ]);

            // Detail Peminjaman
            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku' => $randomBukuId,
                'jumlah' => 1,
            ]);

            // 5. Denda
            if ($status == 'dikembalikan' && rand(0, 1)) {
                Denda::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'jumlah_denda' => rand(1, 5) * 5000,
                    'status_pembayaran' => rand(0, 1) ? 'lunas' : 'belum_bayar',
                ]);
            }
        }
    }
}
