    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Staff Admin | Admin Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            :root {
                --sidebar-color: #1d3557;
                --accent-color: #457b9d;
                --danger-color: #e63946;
            }

            body { 
                margin: 0; 
                font-family: 'Segoe UI', Arial, sans-serif; 
                background: #f4f6f9; 
                overflow-x: hidden;
            }

            /* --- SIDEBAR RESPONSIVE --- */
            .sidebar { 
                height: 100vh; 
                width: 240px; 
                position: fixed; 
                background: var(--sidebar-color); 
                color: white; 
                padding-top: 20px; 
                z-index: 1050; 
                transition: all 0.3s;
            }

            .sidebar h4 { text-align: center; margin-bottom: 30px; font-weight: bold; }
            
            .sidebar a { 
                display: block; 
                color: rgba(255,255,255,0.8); 
                padding: 12px 20px; 
                text-decoration: none; 
                transition: 0.3s; 
                border-left: 5px solid transparent;
            }

            .sidebar a:hover, .sidebar a.active { 
                background: var(--accent-color); 
                color: white; 
                border-left: 5px solid var(--danger-color); 
            }

            /* --- CONTENT AREA --- */
            .content { 
                margin-left: 240px; 
                padding: 30px; 
                min-height: 100vh; 
                transition: all 0.3s;
            }

            .card-table { 
                background: white; 
                border-radius: 12px; 
                padding: 20px; 
                box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            }

            /* --- TOMBOL MENU MOBILE --- */
            .mobile-nav-toggle {
                display: none;
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1100;
                background: var(--sidebar-color);
                color: white;
                border: none;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

            /* --- MEDIA QUERIES --- */
            @media (max-width: 992px) {
                .sidebar { left: -240px; }
                .sidebar.active { left: 0; }
                .content { margin-left: 0; padding: 15px; }
                .mobile-nav-toggle { display: block; }
                .sidebar-overlay.active { display: block; }
                
                h2 { font-size: 1.5rem; }
                
                /* Agar tabel bisa di-scroll ke samping di HP */
                .table-responsive {
                    border: 0;
                }
            }
        </style>
    </head>
    <body>

    <button class="mobile-nav-toggle" id="menuBtn">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar-overlay" id="overlay"></div>

    <div class="sidebar shadow" id="sidebar">
        <h4>🚗 Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="#">📦 Data Mobil</a>
        <a href="{{ route('beli.index') }}">🛒 Data Pembelian</a>
        <a href="{{ route('manage-admin.index') }}" class="active">👥 Staff Admin</a>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0">Staff Admin</h2>
            <a href="{{ route('manage-admin.create') }}" class="btn btn-primary shadow-sm btn-sm btn-md-lg">+ <span class="d-none d-md-inline">Tambah Admin</span></a>
        </div>

        <div class="card-table">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td><b>{{ $admin->nama }}</b></td>
                            <td><span class="badge bg-light text-dark">{{ $admin->posisi }}</span></td>
                            <td>{{ $admin->telepon }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->Alamat }}</td>
                            <td class="text-center">
                                <form action="{{ route('manage-admin.destroy', $admin->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus admin ini?')">
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
    </div>

    <script>
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    </script>

    </body>
    </html>                .fw-extrabold { font-weight: 800 !important; }
        </style>