<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembelian;
use App\Models\Mobil;

class PembelianSeeder extends Seeder
{
    public function run()
    {
        // Ambil satu ID mobil yang sudah ada di tabel mobils
        $mobil = Mobil::first();

        if ($mobil) {
            Pembelian::create([
                'mobil_id'     => $mobil->id,
                'nama_pembeli' => 'Budi Santoso',
                'jumlah'       => 1,
                'total_harga'  => $mobil->harga, // Menyesuaikan harga mobil
            ]);

            Pembelian::create([
                'mobil_id'     => $mobil->id,
                'nama_pembeli' => 'Siti Aminah',
                'jumlah'       => 2,
                'total_harga'  => $mobil->harga * 2,
            ]);
        }
    }
}