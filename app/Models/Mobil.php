<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = ['seri', 'nama_mobil', 'merek', 'mesin', 'transmisi', 'bahan_bakar', 'cc', 'warna', 'tahun', 'penggerak', 'harga', 'stok', 'foto', 'status'];

    public function getFotoAttribute($value)
    {
        if (!$value) {
            return [];
        }

        $photos = json_decode($value, true);
        return is_array($photos) ? $photos : [$value];
    }

    public function setFotoAttribute($value)
    {
        $photos = is_array($value) ? $value : [$value];
        $this->attributes['foto'] = json_encode(array_values(array_filter($photos)));
    }

    /**
     * Helper to check if mobil is available for purchase
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}