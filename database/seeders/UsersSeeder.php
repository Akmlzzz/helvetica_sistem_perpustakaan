<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna;
use App\Models\Anggota;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Create Admin Account in users table
        DB::table('users')->insert([
            'name' => 'Admin Biblio',
            'email' => 'admin@biblio.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get the user ID for creating pengguna record
        $adminUserId = DB::table('users')->where('email', 'admin@biblio.id')->first()->id;

        // Create corresponding Pengguna record
        Pengguna::create([
            'id_pengguna' => $adminUserId,
            'nama_pengguna' => 'admin',
            'email' => 'admin@biblio.id',
            'kata_sandi' => Hash::make('admin123'),
            'level_akses' => 'admin',
        ]);

        // 2. Create Petugas Account
        DB::table('users')->insert([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@biblio.id',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $petugasUserId = DB::table('users')->where('email', 'petugas@biblio.id')->first()->id;

        Pengguna::create([
            'id_pengguna' => $petugasUserId,
            'nama_pengguna' => 'petugas',
            'email' => 'petugas@biblio.id',
            'kata_sandi' => Hash::make('petugas123'),
            'level_akses' => 'petugas',
        ]);

        // 3. Create 25 Anggota Accounts
        for ($i = 1; $i <= 25; $i++) {
            $name = $faker->name;
            $username = 'anggota' . $i;
            $email = 'anggota' . $i . '@biblio.id';

            // Create User account in users table
            DB::table('users')->insert([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('anggota123'),
                'role' => 'pengguna',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $anggotaUserId = DB::table('users')->where('email', $email)->first()->id;

            // Create Pengguna record
            Pengguna::create([
                'id_pengguna' => $anggotaUserId,
                'nama_pengguna' => $username,
                'email' => $email,
                'kata_sandi' => Hash::make('anggota123'),
                'level_akses' => 'anggota',
            ]);

            // Create Anggota record (extended profile)
            Anggota::create([
                'id_pengguna' => $anggotaUserId,
                'nama_lengkap' => $name,
                'alamat' => $faker->address,
                'nomor_telepon' => '08' . $faker->numerify('##########'), // Generate 12-digit phone number
            ]);
        }

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('📊 Created: 1 Admin, 1 Petugas, 25 Anggota');
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('─────────────────────────────────────');
        $this->command->info('Admin:');
        $this->command->info('  Email: admin@biblio.id');
        $this->command->info('  Password: admin123');
        $this->command->info('');
        $this->command->info('Petugas:');
        $this->command->info('  Email: petugas@biblio.id');
        $this->command->info('  Password: petugas123');
        $this->command->info('');
        $this->command->info('Anggota (25 accounts):');
        $this->command->info('  Email: anggota1@biblio.id - anggota25@biblio.id');
        $this->command->info('  Password: anggota123 (same for all)');
    }
}
