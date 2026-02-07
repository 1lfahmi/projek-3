<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .card-form { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-edit text-warning"></i> Edit Admin</h2>
        <a href="{{ route('manage-admin.index') }}" class="btn btn-secondary shadow-sm px-4">Kembali</a>
    </div>

    <div class="card-form">
        <form action="{{ route('manage-admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ $admin->nama }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Posisi</label>
                    <input type="text" name="posisi" class="form-control" value="{{ $admin->posisi }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nomor Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ $admin->telepon }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Kerja</label>
                    <input type="text" name="jam_kerja" class="form-control" value="{{ $admin->jam_kerja }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <input type="text" name="Alamat" class="form-control" value="{{ $admin->Alamat }}" required placeholder="Masukkan alamat lengkap">
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-warning px-5 py-2 shadow-sm fw-bold">Perbarui Data</button>
        </form>
    </div>
</div>
</body>
</html>