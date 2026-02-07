@extends('admin.admin')

@section('main-content')
<div class="container-fluid p-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white">
                <i class="fas fa-receipt text-info me-2"></i> Data Transaksi Penjualan
            </h2>
            <p class="text-muted small mb-0">Kelola dan pantau semua riwayat transaksi pembeli secara real-time.</p>
        </div>
        <div class="text-end">
            <span class="badge px-3 py-2 shadow-sm" style="background: #2563eb; border-radius: 12px; font-weight: 700; color: #ffffff;">
                Total: {{ count($belis) }} Transaksi
            </span>
        </div>
    </div>

    {{-- Tabel Utama --}}
    <div class="card border-0 shadow-lg" style="background: #0f172a; border-radius: 20px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1);">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #1e293b;">
                    <tr>
                        <th class="py-4 px-4 text-center" style="font-size: 11px; color: #94a3b8; text-transform: uppercase;">NO</th>
                        <th class="py-4" style="font-size: 11px; color: #94a3b8; text-transform: uppercase;">Pembeli & Email</th>
                        <th class="py-4" style="font-size: 11px; color: #94a3b8; text-transform: uppercase;">Kontak</th>
                        <th class="py-4" style="font-size: 11px; color: #94a3b8; text-transform: uppercase;">Alamat & Kota</th>
                        <th class="py-4 text-center" style="font-size: 11px; color: #94a3b8; text-transform: uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($belis as $item)
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; transition: 0.3s;">
                        <td class="px-4 text-center fw-bold" style="color: #64748b;">#{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 42px; height: 42px; background: #0f172a; border-radius: 12px; color: #ffffff; font-weight: 800;">
                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold mb-0" style="font-size: 15px; color: #000000;">{{ $item->nama }}</div>
                                    <div style="color: #334155; font-size: 13px; font-weight: 600;">{{ $item->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="https://wa.me/{{ $item->no_telepon }}" target="_blank" 
                               style="background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px; border: 1px solid #bbf7d0;">
                                <i class="fab fa-whatsapp me-2"></i>{{ $item->no_telepon }}
                            </a>
                        </td>
                        <td>
                            <div style="color: #000000; font-size: 13.5px; font-weight: 600;">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $item->alamat }}
                            </div>
                            <span class="badge mt-1" style="background: #e2e8f0; color: #0f172a; font-weight: 800; font-size: 10px; border: 1px solid #cbd5e1;">
                                {{ strtoupper($item->kota) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- BUTTON TRIGGER MODAL --}}
                                <button type="button" class="btn-edit d-flex align-items-center justify-content-center border-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('beli.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del" onclick="return confirm('Hapus data ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT (SATU UNTUK SETIAP BARIS) --}}
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; background: #0f172a;">
                                <div class="modal-header border-0 p-4 pb-0">
                                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit text-warning me-2"></i>Edit Data Transaksi</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('beli.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4 text-start">
                                        <div class="mb-3">
                                            <label class="form-label text-white-50 small fw-bold">NAMA PEMBELI</label>
                                            <input type="text" name="nama" class="form-control bg-dark border-secondary text-white" value="{{ $item->nama }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-white-50 small fw-bold">EMAIL</label>
                                            <input type="email" name="email" class="form-control bg-dark border-secondary text-white" value="{{ $item->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-white-50 small fw-bold">NO. TELEPON</label>
                                            <input type="text" name="no_telepon" class="form-control bg-dark border-secondary text-white" value="{{ $item->no_telepon }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-white-50 small fw-bold">KOTA</label>
                                            <input type="text" name="kota" class="form-control bg-dark border-secondary text-white" value="{{ $item->kota }}" required>
                                        </div>
                                        <div class="mb-0">
                                            <label class="form-label text-white-50 small fw-bold">ALAMAT</label>
                                            <textarea name="alamat" class="form-control bg-dark border-secondary text-white" rows="3" required>{{ $item->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4 pt-0">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                                        <button type="submit" class="btn btn-primary px-4" style="background: #2563eb; border-radius: 10px;">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .btn-edit { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; width: 38px; height: 38px; border-radius: 10px; transition: 0.3s; }
    .btn-edit:hover { background: #f59e0b; color: white; }
    .btn-del { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; width: 38px; height: 38px; border-radius: 10px; transition: 0.3s; border: none; }
    .btn-del:hover { background: #ef4444; color: white; }
    tr:hover { background: #f1f5f9 !important; }
    .form-control:focus { background-color: #1a1a1a !important; border-color: #2563eb !important; color: white; }
</style>
@endsection