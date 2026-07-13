<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar kategori default untuk inventaris kecamatan
        $kategoris = [
            ['nama_kategori' => 'furniture'],
            ['nama_kategori' => 'peralatan elektronik'],
            ['nama_kategori' => 'peralatan kesehatan'],
            ['nama_kategori' => 'Peralatan kebersihan'],
            ['nama_kategori' => 'Peralatan darurat'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate($kategori);
        }
    }
}