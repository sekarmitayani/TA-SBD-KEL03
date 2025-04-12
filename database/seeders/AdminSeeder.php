<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karyawan::firstOrCreate(
            ['email' => 'admin@example.com'], // Cek apakah email ini sudah ada
            [
                'nama' => 'Admin',
                'departemen' => 'IT',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'tanggal_bergabung' => now(),
            ]
        );
    }
}
