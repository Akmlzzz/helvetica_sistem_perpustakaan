<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin account
        Pengguna::updateOrCreate(
            ['email' => 'admin@biblio.com'],
            [
                'nama_pengguna' => 'Administrator',
                'email' => 'admin@biblio.com',
                'kata_sandi' => Hash::make('admin123'),
                'level_akses' => 'admin',
            ]
        );

        $this->command->info('Admin account created successfully!');
        $this->command->info('Email: admin@biblio.com');
        $this->command->info('Password: admin123');
    }
}
