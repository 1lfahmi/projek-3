<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil; // Pastikan memanggil Model Mobil

class FrontController extends Controller
{
    // app/Http/Controllers/FrontController.php

public function index() {
    $mobils = \App\Models\Mobil::all(); // Mengambil semua data mobil dari DB
    return view('welcome', compact('mobils'));
}
}