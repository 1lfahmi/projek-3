<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            /* Memanggil gambar dari folder public/images/ */
            background-image: url('/images/lod.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', sans-serif; 
            min-height: 100vh;
        }

        /* Overlay gelap tipis agar gambar background tidak terlalu mencolok */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Gelapkan 30% */
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .card-form { 
            background: rgba(255, 255, 255, 0.9); /* Putih transparan 90% */
            backdrop-filter: blur(10px); /* Efek blur kaca */
            border-radius: 12px; 
            padding: 30px; 
            box-shadow: 0 8px 32px rgba(0,0,0,0.2); 
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        h2, label {
            color: #333;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white"><i class="fas fa-user-plus"></i> Tambah Admin Baru</h2>
        <a href="{{ route('manage-admin.index') }}" class="btn btn-light shadow-sm px-4 fw-bold">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-form">
        <form action="{{ route('manage-admin.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Ahmad" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Posisi</label>
                    <input type="text" name="posisi" class="form-control" placeholder="Contoh: Manager" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nomor Telepon</label>
                    <input type="text" name="telepon" class="form-control" placeholder="0812..." required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@gmail.com" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Jam Kerja</label>
                    <input type="text" name="jam_kerja" class="form-control" placeholder="08:00 - 17:00" required>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm fw-bold">
                    <i class="fas fa-save"></i> Simpan Data Admin
                </button>
            </div>
        </form>
        @if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    </div>
</div>
</body>
</html>