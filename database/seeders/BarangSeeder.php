<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Barang::insert([
        ['nama_barang' => 'Kamera SLR', 'kategori_barang_id' => 1, 'stok' => 5, 'harga_sewa_per_hari' => 70000],
        ['nama_barang' => 'GoPro Hero', 'kategori_barang_id' => 1, 'stok' => 5, 'harga_sewa_per_hari' => 80000],
        ['nama_barang' => 'Tripod', 'kategori_barang_id' => 2, 'stok' => 7, 'harga_sewa_per_hari' => 25000],
        ['nama_barang' => 'Kursi Lipat', 'kategori_barang_id' => 3, 'stok' => 10, 'harga_sewa_per_hari' => 15000],
        ['nama_barang' => 'Paket Lengkap', 'kategori_barang_id' => 4, 'stok' => 5, 'harga_sewa_per_hari' => 100000],
        ['nama_barang' => 'Tenda', 'kategori_barang_id' => 3, 'stok' => 10, 'harga_sewa_per_hari' => 60000],
        ['nama_barang' => 'Paket Alat BBQ', 'kategori_barang_id' => 4, 'stok' => 10, 'harga_sewa_per_hari' => 50000],
        ['nama_barang' => 'Paket Camping', 'kategori_barang_id' => 4, 'stok' => 5, 'harga_sewa_per_hari' => 120000],
    ]);
}
}
