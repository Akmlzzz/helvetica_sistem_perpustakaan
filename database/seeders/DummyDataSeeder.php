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
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Kategori
        $kategoriNames = ['Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Seni', 'Biografi', 'Bisnis', 'Anak-anak'];
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
            ['judul_buku' => 'Filosofi Teras', 'penulis' => 'Henry Manampiring', 'stok' => 8],
            ['judul_buku' => 'Laut Bercerita', 'penulis' => 'Leila S. Chudori', 'stok' => 6],
            ['judul_buku' => 'Atomic Habits', 'penulis' => 'James Clear', 'stok' => 12],
            ['judul_buku' => 'Rich Dad Poor Dad', 'penulis' => 'Robert Kiyosaki', 'stok' => 9],
            ['judul_buku' => 'Pulang', 'penulis' => 'Leila S. Chudori', 'stok' => 5],
        ];

        foreach ($bukuData as $index => $data) {
            Buku::updateOrCreate(
                ['judul_buku' => $data['judul_buku']],
                [
                    'isbn' => $faker->isbn13(),
                    'penulis' => $data['penulis'],
                    'penerbit' => $faker->company(),
                    'stok' => $data['stok'],
                    'id_kategori' => $kategoriIds[array_rand($kategoriIds)],
                    'lokasi_rak' => 'Rak ' . $faker->randomLetter() . '-' . $faker->randomNumber(2),
                ]
            );
        }
        $bukuIds = Buku::pluck('id_buku')->toArray();

        // 3. Pengguna & Anggota
        // Create Admin
        $admin = Pengguna::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'nama_pengguna' => 'Administrator',
                'kata_sandi' => Hash::make('password'),
                'level_akses' => 'admin',
            ]
        );
        Anggota::updateOrCreate(
            ['id_pengguna' => $admin->id_pengguna],
            [
                'nama_lengkap' => 'Administrator Sistem',
                'alamat' => 'Jakarta',
                'nomor_telepon' => '081234567890',
            ]
        );

        // Create Petugas
        $petugas = Pengguna::updateOrCreate(
            ['email' => 'petugas@petugas.com'],
            [
                'nama_pengguna' => 'Petugas1',
                'kata_sandi' => Hash::make('password'),
                'level_akses' => 'petugas',
            ]
        );
        Anggota::updateOrCreate(
            ['id_pengguna' => $petugas->id_pengguna],
            [
                'nama_lengkap' => 'Budi Petugas',
                'alamat' => 'Bandung',
                'nomor_telepon' => '081234567891',
            ]
        );


        // Create Anggota (Members)
        for ($i = 1; $i <= 15; $i++) {
            $email = $faker->unique()->email();
            $pengguna = Pengguna::updateOrCreate(
                ['email' => $email],
                [
                    'nama_pengguna' => $faker->userName(),
                    'kata_sandi' => Hash::make('password'),
                    'level_akses' => 'anggota',
                ]
            );

            Anggota::updateOrCreate(
                ['id_pengguna' => $pengguna->id_pengguna],
                [
                    'nama_lengkap' => $faker->name(),
                    'alamat' => $faker->address(),
                    'nomor_telepon' => $faker->numerify('08##########'),
                ]
            );
        }
        $penggunaIds = Pengguna::where('level_akses', 'anggota')->pluck('id_pengguna')->toArray();

        // 4. Peminjaman
        $statuses = ['dipinjam', 'dikembalikan', 'terlambat'];
        for ($i = 1; $i <= 20; $i++) {
            $tglPinjam = Carbon::now()->subDays(rand(1, 30))->toDateString();
            $status = $statuses[array_rand($statuses)];
            $tglKembali = ($status == 'dikembalikan') ? Carbon::parse($tglPinjam)->addDays(rand(3, 10))->toDateString() : Carbon::parse($tglPinjam)->addDays(7)->toDateString(); // Default deadline 7 days

            if ($status == 'terlambat') {
                // Make sure tgl_kembali (deadline) is in the past relative to now if it's late
                // But in this logic, tgl_kembali is the DEADLINE usually, or actual return date?
                // Usually tgl_kembali is the planned return date.
                // If status is telat, it means today > tgl_kembali and not returned yet?
                // Or tgl_kembali is the actual return date?
                // Let's assume tgl_kembali field in DB is the DEADLINE in this schema based on typical simple libs.
                // Wait, checking Peminjaman table structure...
                // Based on view: 'Deadline' column uses $item->tgl_kembali.
                // So tgl_kembali is DEADLINE.
                // Actual return date might be separate or handled by status.
            }

            $randomBukuId = $bukuIds[array_rand($bukuIds)];
            $idPengguna = $penggunaIds[array_rand($penggunaIds)];

            $peminjaman = Peminjaman::create([
                'id_pengguna' => $idPengguna,
                'id_buku' => $randomBukuId,
                'tgl_pinjam' => $tglPinjam,
                'tgl_kembali' => Carbon::parse($tglPinjam)->addDays(7)->toDateString(), // Deadline
                'status_transaksi' => $status,
            ]);

            // Detail Peminjaman (Assuming One to Many/One relationship logic simplified here)
            // If DetailPeminjaman exists and is linked.
            // The view shows $item->detail->buku->judul_buku
            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku' => $randomBukuId,
                'jumlah' => 1,
            ]);

            // 5. Denda
            if ($status == 'terlambat' || ($status == 'dikembalikan' && rand(0, 1))) {
                // If late, or returned late
                Denda::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'jumlah_denda' => rand(1, 10) * 1000,
                    'status_pembayaran' => rand(0, 1) ? 'lunas' : 'belum_bayar',
                ]);
            }
        }
    }
}
