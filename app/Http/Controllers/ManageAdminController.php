<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class ManageAdminController extends Controller
{
    // 1. READ: Menampilkan semua staff di tabel
    public function index()
    {
        $admins = Admin::all();
        return view('admin.staff.index', compact('admins'));
    }

    // 2. CREATE: Menampilkan form tambah
    public function create()
    {
        return view('admin.manage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'posisi' => 'required',
            'telepon' => 'required',
            'email' => 'required|email|unique:admins',
            'jam_kerja' => 'required',
            'Alamat' => 'required', // Pastikan di database & form input namanya 'Alamat' (A kapital)
        ]);

        Admin::create([
            'nama' => $request->nama,
            'posisi' => $request->posisi,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'jam_kerja' => $request->jam_kerja,
            'Alamat' => $request->Alamat,
        ]);

        return redirect()->route('manage-admin.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.manage.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        
        $request->validate([
            'nama' => 'required',
            'posisi' => 'required',
            'telepon' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'jam_kerja' => 'required',
            'Alamat' => 'required', // Tambahkan validasi alamat di sini
        ]);

        // Tambahkan 'Alamat' ke dalam fungsi only() agar datanya ikut terambil
        $data = $request->only(['nama', 'posisi', 'telepon', 'email', 'jam_kerja', 'Alamat']);
        
        if($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('manage-admin.index')->with('success', 'Data admin berhasil diperbarui');
    }

    // 4. DELETE: Menghapus staff admin
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('manage-admin.index')->with('success', 'Admin berhasil dihapus');
    }
}