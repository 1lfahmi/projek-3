<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Staff Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; }
        .sidebar { height: 100vh; width: 240px; position: fixed; background: #1d3557; color: white; padding-top: 20px; z-index: 1000; }
        .sidebar h4 { text-align: center; margin-bottom: 30px; font-weight: bold; }
        .sidebar a { display: block; color: rgba(255,255,255,0.8); padding: 12px 20px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #457b9d; color: white; border-left: 5px solid #e63946; }
        .content { margin-left: 240px; padding: 30px; min-height: 100vh; }
        .card-table { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="sidebar shadow">
    <h4>🚗 Admin Panel</h4>
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
    <a href="#">📦 Data Mobil</a>
    <a href="{{ route('beli.index') }}">🛒 Data Pembelian</a>
    <a href="{{ route('manage-admin.index') }}" class="active">👥 Staff Admin</a>
</div>

<div class="content">
    <div class="d-flex justify-content-between mb-4">
        <h2 class="fw-bold">Staff Admin</h2>
        <a href="{{ route('manage-admin.create') }}" class="btn btn-primary shadow-sm">+ Tambah Admin</a>
    </div>
    <div class="card-table">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th><th>Posisi</th><th>Telepon</th><th>Email</th><th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
    @foreach($admins as $admin)
    <tr>
        <td><b>{{ $admin->nama }}</b></td>
        <td>{{ $admin->posisi }}</td>
        <td>{{ $admin->telepon }}</td>
        <td>{{ $admin->email }}</td>
        <td>{{ $admin->jam_kerja }}</td> <td class="text-center">
            <form action="{{ route('manage-admin.destroy', $admin->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>
</body>
</html>