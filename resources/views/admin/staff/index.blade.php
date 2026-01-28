@extends('admin.admin') 

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manajemen Staff Admin</h2>
    <a href="{{ route('manage-admin.create') }}" class="btn btn-primary shadow-sm px-3">
        <i class="fas fa-user-plus me-1"></i> Tambah Admin
    </a>
</div>

<div class="card shadow border-0 rounded-3">
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td><strong>{{ $admin->nama }}</strong></td>
                        <td><span class="badge bg-info text-dark">{{ $admin->posisi }}</span></td>
                        <td>{{ $admin->telepon }}</td>
                        <td>{{ $admin->email }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('manage-admin.edit', $admin->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit text-white"></i>
                                </a>

                                <form action="{{ route('manage-admin.destroy', $admin->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection