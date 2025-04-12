<?php
namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run()
    {
        $karyawans = [
            [
                'nama' => 'Ahmad Fajar',
                'departemen' => 'IT',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'tanggal_bergabung' => now(),
            ],
            [
                'nama' => 'Halmar Bintang',
                'departemen' => 'Keuangan',
                'email' => 'halmar@example.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'tanggal_bergabung' => now(),
            ],
            [
                'nama' => 'Reyhan Zidany',
                'departemen' => 'Umum',
                'email' => 'reyhan@example.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'tanggal_bergabung' => now(),
            ],
            [
                'nama' => 'Sekar Mitayani',
                'departemen' => 'IT',
                'email' => 'sekar@example.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
                'tanggal_bergabung' => now(),
            ],
        ];

        foreach ($karyawans as $karyawan) {
            Karyawan::firstOrCreate(
                ['email' => $karyawan['email']],
                $karyawan
            );
        }
    }
}
