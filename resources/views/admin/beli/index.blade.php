@extends('admin.admin')

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-white" style="letter-spacing: -1px;">
        <i class="fas fa-file-invoice-dollar text-info me-2"></i> Data Penjualan
    </h2>
</div>

<div class="stat-card">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="background: rgba(16, 185, 129, 0.2); color: #4ade80;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle" style="color: #cbd5e1;">
            <thead style="background: rgba(15, 23, 42, 0.5);">
                <tr class="text-white border-bottom border-secondary">
                    <th width="50" class="py-3 px-3">No</th>
                    <th class="py-3">Nama Pembeli</th>
                    <th class="py-3">Telepon</th>
                    <th class="py-3">Alamat</th>
                    <th class="text-center py-3" width="100">Aksi</th>
                </tr>
            </thead>
            <tbody style="border-top: none;">
                @foreach($belis as $item)
                <tr class="border-bottom border-secondary" style="transition: 0.3s;">
                    <td class="px-3 fw-bold text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-bold text-white">{{ $item->nama }}</div>
                        <small style="color: #94a3b8;">Customer</small>
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(56, 189, 248, 0.1); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.2);">
                            <i class="fas fa-phone-alt me-1" style="font-size: 10px;"></i> {{ $item->no_telepon }}
                        </span>
                    </td>
                    <td style="font-size: 0.9rem; max-width: 250px;">{{ $item->alamat }}</td>
                    <td class="text-center">
                        <form action="{{ route('beli.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger border-0" 
                                    onclick="return confirm('Yakin ingin menghapus data pesanan ini?')"
                                    style="background: rgba(244, 63, 94, 0.1); padding: 8px 12px;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($belis->isEmpty())
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <i class="fas fa-folder-open d-block mb-3 text-muted" style="font-size: 3rem;"></i>
                        <span class="text-muted">Belum ada data pembelian masuk.</span>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<style>
    /* Efek hover pada baris tabel agar lebih interaktif */
    .table tbody tr:hover {
        background: rgba(255, 255, 255, 0.03) !important;
    }
</style>
@endsection