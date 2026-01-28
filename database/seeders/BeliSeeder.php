<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beli; // Pastikan memanggil model Beli

class BeliSeeder extends Seeder
{
    public function run(): void
    {
        Beli::create([
            'nama' => 'Ahmad Riyanto',
            'email' => 'ahmad@example.com',
            'no_telepon' => '085191163819',
            'alamat' => 'Jl. Merdeka No. 123',
            'kota' => 'Jakarta',
        ]);
    }
}