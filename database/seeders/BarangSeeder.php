<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Barang::create([
        'nama_barang' => 'Laptop',
        'harga' => 7500000,
        'kategori_id' => 1,
        'tanggal_pembelian' => now(),
        'updated_at' => now(),
        'created_at' => now(),
        'spesifikasi' => 'Intel Core i7, 16GB RAM, 512GB SSD',   
        'status' => 'tersedia',
        'lokasi' => 'Ruang IT',
        'kode_aset' => 'IT-001',               
    ]);
}
}
