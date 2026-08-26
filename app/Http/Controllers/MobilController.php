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
        $mobils = Mobil::where(function ($query) {
            $query->whereNull('status')->orWhere('status', '!=', 'sold');
        })->get();
        
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
            'mesin'      => 'nullable|string|max:100',
            'transmisi'  => 'nullable|string|max:50',
            'bahan_bakar'=> 'nullable|string|max:50',
            'cc'         => 'nullable|integer|min:1',
            'warna'      => 'nullable|string|max:50',
            'tahun'      => 'nullable|integer|min:1900',
            'penggerak'  => 'nullable|string|max:50',
            'harga'      => 'required|numeric',
            'stok'       => 'required|numeric',
            'foto'       => 'required|array|min:1|max:5',
            'foto.*'     => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $disk = env('FILESYSTEM_DISK', 'local');

        // Logika Upload Foto
        if ($request->hasFile('foto')) {
            $data['foto'] = collect($request->file('foto'))
                ->map(fn ($file) => $file->store('mobil', $disk))
                ->all();
        }

        Mobil::create($data);

        return redirect()->back()->with('success', 'Mobil berhasil ditambahkan dan foto tersimpan!');
    }

    // Fungsi untuk mengambil data yang akan diedit (AJAX JSON)
    public function edit($id)
    {
        $mobil = Mobil::find($id);
        $data = $mobil->toArray();
        $data['foto_url'] = collect($mobil->foto)->map(fn ($photo) => Storage::url($photo))->values()->all();

        return response()->json($data);
    }

    // Fungsi untuk menyimpan perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'seri'       => 'required',
            'nama_mobil' => 'required',
            'merek'      => 'required',
            'mesin'      => 'nullable|string|max:100',
            'transmisi'  => 'nullable|string|max:50',
            'bahan_bakar'=> 'nullable|string|max:50',
            'cc'         => 'nullable|integer|min:1',
            'warna'      => 'nullable|string|max:50',
            'tahun'      => 'nullable|integer|min:1900',
            'penggerak'  => 'nullable|string|max:50',
            'harga'      => 'required|numeric',
            'stok'       => 'required|numeric',
            'foto'       => 'nullable|array|max:5',
            'foto.*'     => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mobil = Mobil::findOrFail($id);
        $data = $request->all();

        // Logika Update Foto
        if ($request->hasFile('foto')) {
            $disk = env('FILESYSTEM_DISK', 'local');
            $newPhotos = collect($request->file('foto'))
                ->map(fn ($file) => $file->store('mobil', $disk))
                ->all();
            $data['foto'] = array_merge($mobil->foto, $newPhotos);
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
            $disk = env('FILESYSTEM_DISK', 'local');
            Storage::disk($disk)->delete($mobil->foto);
        }

        $mobil->delete(); 

        return redirect()->back()->with('success', 'Data mobil dan fotonya berhasil dihapus!');
    }

    // Set mobil status back to 'available' (admin action)
    public function setAvailable($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->status = 'available';
        $mobil->save();

        return redirect()->back()->with('success', 'Status mobil diubah menjadi tersedia.');
    }
}