<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = ['seri', 'nama_mobil', 'merek', 'mesin', 'transmisi', 'bahan_bakar', 'cc', 'warna', 'tahun', 'penggerak', 'harga', 'stok', 'foto', 'status'];

    /**
     * Helper to check if mobil is available for purchase
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}