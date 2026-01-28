<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins'; // Nama tabel di database

    protected $fillable = ['nama', 'posisi', 'telepon', 'email', 'jam_kerja'];

}