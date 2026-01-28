<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil; 
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk hapus foto lama

class MobilController extends Controller
{
    // Menampilkan halaman daftar mobil
    public function index()
    {
        $mobils = Mobil::all();
        
        // Data pendukung dashboard
        $totalMobil = Mobil::count();
        $totalPesanan = \App\Models\Pembelian::count(); 
        $totalUser = \App\Models\User::count();

        return view('mobil', compact('mobils', 'totalMobil', 'totalPesanan', 'totalUser'));
    }

    // Menyimpan data mobil baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'seri'       => 'required', // Tambahkan validasi seri
            'nama_mobil' => 'required',
            'merek'      => 'required',
            'harga'      => 'required|numeric',
            'stok'       => 'required|numeric',
            'foto'       => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        $data = $request->all();

        // Logika Upload Foto
        if ($request->hasFile('foto')) {
            // Simpan foto ke folder storage/app/public/mobil
            $data['foto'] = $request->file('foto')->store('mobil', 'public');
        }

        Mobil::create($data);

        return redirect()->back()->with('success', 'Mobil berhasil ditambahkan dan foto tersimpan!');
    }

    // Fungsi untuk mengambil data yang akan diedit (AJAX JSON)
    public function edit($id)
    {
        $mobil = Mobil::find($id);
        return response()->json($mobil); 
    }

    // Fungsi untuk menyimpan perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'seri'       => 'required',
            'nama_mobil' => 'required',
            'merek'      => 'required',
            'harga'      => 'required|numeric',
            'stok'       => 'required|numeric',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Foto opsional saat edit
        ]);

        $mobil = Mobil::findOrFail($id);
        $data = $request->all();

        // Logika Update Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage agar tidak memenuhi memori
            if ($mobil->foto) {
                Storage::disk('public')->delete($mobil->foto);
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('mobil', 'public');
        }

        $mobil->update($data);

        return redirect()->back()->with('success', 'Data mobil berhasil diperbarui!');
    }

    // Menghapus data mobil
    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        
        // Hapus foto dari storage saat data dihapus
        if ($mobil->foto) {
            Storage::disk('public')->delete($mobil->foto);
        }

        $mobil->delete(); 

        return redirect()->back()->with('success', 'Data mobil dan fotonya berhasil dihapus!');
    }
}