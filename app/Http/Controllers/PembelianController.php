<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Mobil;

class PembelianController extends Controller
{
    // 🔹 TAMPILKAN DATA KE DASHBOARD ADMIN
    public function index()
    {
        $belis = Pembelian::where(function ($query) {
            $query->whereNull('status')->orWhere('status', '!=', 'completed');
        })->latest()->get();
        return view('admin.pembelian', compact('belis'));
    }

    public function history()
    {
        $belis = Pembelian::where('status', 'completed')->latest()->get();
        return view('admin.riwayat', compact('belis'));
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
            'nama_mobil'  => 'required',
            'mobilId'     => 'required'
        ]);

        // Lock the mobil (mark as reserved) so others cannot buy it while being handled
        $mobil = Mobil::find($request->input('mobilId'));
        if ($mobil) {
            if ($mobil->status !== 'available') {
                return response()->json(['message' => 'Mobil tidak tersedia'], 400);
            }
            $mobil->status = 'reserved';
            $mobil->save();
        }

        $pembelianData = $request->only(['nama','email','no_telepon','kota','alamat','nama_mobil']);
        $pembelianData['mobil_id'] = $mobil ? $mobil->id : null;
        $pembelian = Pembelian::create($pembelianData);

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

    // Admin confirms the purchase and marks mobil as sold
    public function confirm($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        if ($pembelian->status === 'completed') {
            return redirect()->back()->with('success', 'Transaksi sudah dikonfirmasi.');
        }

        $pembelian->status = 'completed';
        $pembelian->save();

        if ($pembelian->mobil_id) {
            $mobil = Mobil::find($pembelian->mobil_id);
            if ($mobil) {
                $mobil->status = 'sold';
                // optionally decrement stock
                if ($mobil->stok > 0) $mobil->stok = max(0, $mobil->stok - 1);
                $mobil->save();
            }
        }

        return redirect()->route('admin.pembelian')->with('success', 'Transaksi berhasil dikonfirmasi dan mobil ditandai terbeli.');
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
            'nama_mobil'  => 'required',
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

        if ($pembelian->status !== 'completed' && $pembelian->mobil_id) {
            $mobil = Mobil::find($pembelian->mobil_id);
            if ($mobil && $mobil->status === 'reserved') {
                $mobil->status = 'available';
                $mobil->save();
            }
        }

        $pembelian->delete();
        
        return redirect()->route('admin.pembelian')->with('success', 'Data penjualan berhasil dihapus!');
    }
}