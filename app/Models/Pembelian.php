<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'kota',
        'alamat',
        'nama_mobil'
    ];
}
