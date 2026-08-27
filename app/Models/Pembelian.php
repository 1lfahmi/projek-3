<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    public function getWhatsappNumberAttribute(): string
    {
        $number = preg_replace('/\D+/', '', (string) $this->no_telepon);

        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        if (str_starts_with($number, '8')) {
            return '62' . $number;
        }

        return $number;
    }

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'kota',
        'alamat',
        'nama_mobil',
        'mobil_id',
        'status'
    ];
}
