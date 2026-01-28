<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mobil; // Sesuaikan dengan nama model mobil kamu

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        // Data dari phpMyAdmin kamu
        Mobil::create([
            'nama_mobil' => 'porcshe',
            'merek' => 'mitsubisi',
            'harga' => 230,
            'stok' => 56,
        ]);

        Mobil::create([
            'nama_mobil' => 'dogma',
            'merek' => 'honda',
            'harga' => 124,
            'stok' => 6,
        ]);

        Mobil::create([
            'nama_mobil' => 'ragunan',
            'merek' => 'sambar',
            'harga' => 234,
            'stok' => 3,
        ]);
    }
}