<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    \App\Models\KategoriBarang::insert([
        ['nama_kategori' => 'Kamera'],
        ['nama_kategori' => 'Tripod'],
        ['nama_kategori' => 'Furniture'],
        ['nama_kategori' => 'Paket'],
    ]);
}
}
