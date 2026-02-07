<?php

namespace App\Http\Controllers;

use App\Models\Mobil;      // Pastikan Model Mobil ada
use App\Models\Pembelian;  // Pastikan Model Pembelian ada
use App\Models\User;       // Pastikan Model User ada
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index() {
        $mobils = Mobil::all();
        return view('admin.mobil.index', compact('mobils'));
    }

    public function dashboard()
    {
        // Mengambil jumlah data real-time dari database
        $totalMobil = Mobil::count();
        $totalPesanan = Pembelian::count(); 
        $totalUser = User::count();

        // Mengirimkan data ke view admin.dashboard
        return view('admin.dashboard', compact('totalMobil', 'totalPesanan', 'totalUser'));
    }
}