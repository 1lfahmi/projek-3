@extends('admin.admin')

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-dark">🛒 Data Pembelian</h2>
</div>

<div class="card shadow border-0 rounded-3">
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Pembeli</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th class="text-center" width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($belis as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td><span class="badge bg-success">{{ $item->no_telepon }}</span></td>
                        <td>{{ $item->alamat }}</td>
                        <td class="text-center">
                            <form action="{{ route('beli.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger shadow-sm" onclick="return confirm('Hapus data pembelian ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    @if($belis->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data pembelian masuk.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection