@extends('admin.admin') 

@section('main-content')
<div class="card shadow border-0 rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Data Mobil</h5>
        <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahMobil">
            <i class="fas fa-plus me-1"></i> Tambah Mobil
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Seri</th>
                        <th>Nama Mobil</th>
                        <th>Merek</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mobils as $m)
                    <tr>
                        <td>
                            @if($m->foto)
                                <img src="{{ asset('storage/' . $m->foto) }}" width="70" class="rounded shadow-sm">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width:70px; height:50px;">
                                    <small class="text-muted">No Pic</small>
                                </div>
                            @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ $m->seri }}</span></td>
                        <td>{{ $m->nama_mobil }}</td>
                        <td>{{ $m->merek }}</td>
                        <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                        <td>{{ $m->stok }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm text-white" onclick="editMobil('{{ $m->id }}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            
                            <form action="{{ route('mobil.destroy', $m->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data mobil di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahMobil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('mobil.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Seri</label>
                    <input type="text" name="seri" class="form-control mb-2" placeholder="#MB001" required>
                    <label class="form-label">Nama Mobil</label>
                    <input type="text" name="nama_mobil" class="form-control mb-2" required>
                    <label class="form-label">Merek</label>
                    <input type="text" name="merek" class="form-control mb-2" required>
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control mb-2" required>
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control mb-2" required>
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control mb-2" accept="image/*" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditMobil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <form id="formEditMobil" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title fw-bold">Edit Data Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Seri Mobil</label>
                    <input type="text" name="seri" id="edit_seri" class="form-control mb-2" required>
                    <label class="form-label">Nama Mobil</label>
                    <input type="text" name="nama_mobil" id="edit_nama" class="form-control mb-2" required>
                    <label class="form-label">Merek</label>
                    <input type="text" name="merek" id="edit_merek" class="form-control mb-2" required>
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" id="edit_harga" class="form-control mb-2" required>
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" id="edit_stok" class="form-control mb-2" required>
                    <label class="form-label">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" class="form-control mb-2" accept="image/*">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning text-white w-100">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/mobil.js') }}"></script>
@endsection