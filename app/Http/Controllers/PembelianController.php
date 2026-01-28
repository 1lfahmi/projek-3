<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;

class PembelianController extends Controller
{
    public function store(Request $request) {
        // Validasi data
        $validated = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'required',
            'alamat' => 'required',
            'kota' => 'required',
        ]);
    
        // Simpan ke database
        Pembelian::create($validated);
    
        return redirect()->back()->with('success', 'Pesanan berhasil dikirim!');
    }
}
