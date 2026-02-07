<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;

class PembelianController extends Controller
{
    // 🔹 TAMPILKAN DATA KE DASHBOARD ADMIN
    public function index()
    {
        $belis = Pembelian::latest()->get();
        return view('admin.pembelian', compact('belis'));
    }

    // 🔹 SIMPAN DATA + BUKA WHATSAPP
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'email'       => 'required|email',
            'no_telepon'  => 'required',
            'kota'        => 'required',
            'alamat'      => 'required',
            'nama_mobil'  => 'required'
        ]);

        $pembelian = Pembelian::create($request->all());

        $pesan = "Halo Admin,%0A%0ASaya ingin membeli kendaraan:%0A".
                 "Nama: {$pembelian->nama}%0A".
                 "Mobil: {$pembelian->nama_mobil}%0A".
                 "No HP: {$pembelian->no_telepon}%0A".
                 "Kota: {$pembelian->kota}%0A".
                 "Alamat: {$pembelian->alamat}";

        $urlWa = "https://wa.me/6288220273210?text=$pesan";

        return response()->json([
            'message' => 'Pesanan berhasil dikirim!',
            'target_url' => $urlWa
        ]);
    }

    // 🔹 TAMPILKAN FORM EDIT
    public function edit($id)
    {
        // Mencari data berdasarkan ID, jika tidak ada akan muncul error 404
        $beli = Pembelian::findOrFail($id);
        
        // Mengarahkan ke file view edit (Pastikan kamu buat file: resources/views/admin/edit_pembelian.blade.php)
        return view('admin.edit_pembelian', compact('beli'));
    }

    // 🔹 PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required',
            'email'       => 'required|email',
            'no_telepon'  => 'required',
            'kota'        => 'required',
            'alamat'      => 'required',
        ]);

        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update($request->all());

        return redirect()->route('admin.pembelian')->with('success', 'Data transaksi berhasil diperbarui!');
    }

    // 🔹 HAPUS DATA
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();
        
        return redirect()->route('admin.pembelian')->with('success', 'Data penjualan berhasil dihapus!');
    }
}