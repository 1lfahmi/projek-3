<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    // Tambahkan ini jika nama tabel di database kamu adalah 'belis'
    protected $table = 'pembelians'; 

    // Tambahkan ini agar data bisa disimpan (Mass Assignment)
    protected $fillable = ['nama', 'email', 'telepon', 'alamat', 'kota'];
}