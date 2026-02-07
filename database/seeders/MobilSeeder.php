<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mobil;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        Mobil::create([
            'seri' => 'SR-001',
            'nama_mobil' => 'Porsche',
            'merek' => 'Mitsubishi',
            'harga' => 230000000,
            'stok' => 56,
        ]);

        Mobil::create([
            'seri' => 'SR-002',
            'nama_mobil' => 'Dogma',
            'merek' => 'Honda',
            'harga' => 124000000,
            'stok' => 6,
        ]);

        Mobil::create([
            'seri' => 'SR-003',
            'nama_mobil' => 'Ragunan',
            'merek' => 'Sambar',
            'harga' => 234000000,
            'stok' => 3,
        ]);
    }
}
