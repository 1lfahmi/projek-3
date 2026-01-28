<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian; // Pastikan menggunakan model Pembelian secara konsisten


class BeliController extends Controller
{
    public function index()
    {
        // Mengambil semua data untuk ditampilkan di tabel Admin
        $pembelians = Pembelian::all();
        return view('admin.pembelian', compact('pembelians'));
    }

    public function store(Request $request)
{
    // Simpan ke database (Dashboard)
    \App\Models\Pembelian::create($request->all());

    // AMBIL DATA DARI FORM (PENTING: Agar tidak merah lagi)
    $nama = $request->nama; 
    $mobil = $request->nama_mobil; 

    // Susun Link WA
    $urlWa = "https://wa.me/6281234567890?text=" . urlencode("Halo, saya $nama ingin membeli unit $mobil");

    // Kirim URL ke JavaScript
    return response()->json([
        'message' => 'Pesanan Berhasil! Data sudah masuk ke sistem.',
        'target_url' => $urlWa
    ]);
}


    public function destroy($id)
    {
        // Gunakan Pembelian:: agar konsisten dengan tabel yang ada
        $data = Pembelian::findOrFail($id);
        $data->delete();

        // Redirect kembali ke halaman daftar pembelian admin
        return redirect()->route('admin.pembelian')->with('success', 'Data berhasil dihapus');
    }
    
}