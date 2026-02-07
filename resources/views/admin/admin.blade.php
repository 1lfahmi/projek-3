<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | Premium Drive</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-deep: #020617;        /* Hitam Luar Angkasa */
            --bg-surface: #0f172a;     /* Navy Gelap */
            --accent-main: #3b82f6;    /* Biru Elektrik */
            --accent-success: #10b981; /* Emerald Neon */
            --text-main: #f8fafc;
            --text-muted: #64748b;
            --border-soft: rgba(255, 255, 255, 0.05);
            --glass: rgba(15, 23, 42, 0.8);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-deep);
            color: var(--text-main);
            margin: 0;
            letter-spacing: -0.2px;
        }

        /* --- SIDEBAR GLASSMORPHISM --- */
        .sidebar { 
            height: 100vh; width: 270px; position: fixed; 
            background: linear-gradient(180deg, #020617 0%, #0f172a 100%);
            border-right: 1px solid var(--border-soft);
            z-index: 1050; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand { 
            padding: 2.5rem 1.5rem; font-weight: 800; font-size: 1.6rem; 
            background: linear-gradient(to right, #fff, var(--accent-main));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .sidebar a { 
            color: var(--text-muted); text-decoration: none; padding: 14px 20px; 
            display: flex; align-items: center; margin: 4px 16px;
            border-radius: 14px; font-weight: 600; transition: 0.3s;
        }

        .sidebar a i { font-size: 1.2rem; margin-right: 12px; transition: 0.3s; }

        .sidebar a:hover, .sidebar a.active { 
            background: rgba(59, 130, 246, 0.1); 
            color: var(--accent-main);
            transform: translateX(5px);
        }

        .sidebar a.active i { color: var(--accent-main); filter: drop-shadow(0 0 8px var(--accent-main)); }

        /* --- MAIN AREA --- */
        .main-container { margin-left: 270px; min-height: 100vh; }

        .navbar { 
            background: var(--glass); backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-soft); padding: 1.2rem 2rem;
            position: sticky; top: 0; z-index: 1000;
        }

        /* --- MODAL DESIGN (ULTRA CLEAN) --- */
        .modal-content {
            background: #0f172a !important;
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 30px;
            padding: 1.2rem;
            box-shadow: 0 0 50px rgba(0,0,0,0.8);
            animation: modalSlide 0.4s ease-out;
        }

        @keyframes modalSlide {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header { border: none; padding-bottom: 0; }
        .modal-title { font-weight: 800; font-size: 1.5rem; letter-spacing: -0.5px; }
        .btn-close { filter: invert(1); opacity: 0.5; }

        /* --- INPUT FIELD EVOLUTION --- */
        .form-label {
            font-size: 0.85rem; font-weight: 700; color: var(--accent-main);
            margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;
        }

        .form-control {
            background: rgba(2, 6, 23, 0.8) !important;
            border: 1px solid var(--border-soft) !important;
            border-radius: 16px; color: #fff !important;
            padding: 14px 18px; transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-main) !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            background: #020617 !important;
        }

        /* --- BUTTONS --- */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-main), #1d4ed8);
            border: none; border-radius: 16px; padding: 14px;
            font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.5);
        }

        /* --- DASHBOARD ELEMENTS --- */
        .stat-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border: 1px solid var(--border-soft);
            border-radius: 24px; padding: 2rem;
            transition: 0.4s;
        }

        .stat-card:hover { transform: translateY(-10px); border-color: var(--accent-main); }

        .btn-toggle-sidebar {
            display: none; position: fixed; bottom: 30px; right: 30px;
            z-index: 2000; background: var(--accent-main); color: white;
            border: none; width: 65px; height: 65px; border-radius: 20px;
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        @media (max-width: 992px) {
            .sidebar { left: -270px; }
            .sidebar.active { left: 0; box-shadow: 50px 0 100px rgba(0,0,0,0.9); }
            .main-container { margin-left: 0; }
            .btn-toggle-sidebar { display: block; }
        }
    </style>
</head>
<body>

    <button class="btn-toggle-sidebar" id="btnToggle">
        <i class="fas fa-bars-staggered"></i>
    </button>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand text-center">
            <i class="fas fa-rocket me-2"></i>PREMIUM DRIVE
        </div>
        
        <nav class="mt-2 flex-grow-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-grid-2 me-2"></i> Dashboard
            </a>
            <a href="{{ route('mobil.index') }}" class="{{ request()->is('mobil*') ? 'active' : '' }}">
                <i class="fas fa-car-rear me-2"></i> Data Kendaraan
            </a>
            <a href="{{ route('admin.pembelian') }}" class="{{ request()->is('admin/pembelian*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i> Penjualan
            </a>
            <a href="{{ route('manage-admin.index') }}" class="{{ request()->is('manage-admin*') ? 'active' : '' }}">
                <i class="fas fa-user-gear me-2"></i> Staff Akses
            </a>

            <div style="margin-top: 80px;">
                <a href="#" class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off me-2"></i> Sign Out
                </a>
            </div>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </aside>

    <div class="main-container">
        <nav class="navbar d-flex justify-content-between">
            <div class="text-muted fw-bold small">SYSTEM / <span class="text-white">CONTROL PANEL</span></div>
            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-md-block">
                    <div class="fw-bold text-white lh-1">{{ Auth::user()->name }}</div>
                    <small class="text-success fw-bold" style="font-size: 0.7rem;">● ONLINE</small>
                </div>
                <div class="rounded-4 bg-primary d-flex align-items-center justify-content-center shadow-lg" style="width: 45px; height: 45px; border: 2px solid var(--accent-main)">
                    <i class="fas fa-user-astronaut text-white"></i>
                </div>
            </div>
        </nav>

        <div class="p-4 p-md-5">
            <div class="content-area">
                @yield('main-content')
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btnToggle = document.getElementById('btnToggle');
        const sidebar = document.getElementById('sidebar');
        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            btnToggle.innerHTML = sidebar.classList.contains('active') ? '<i class="fas fa-xmark"></i>' : '<i class="fas fa-bars-staggered"></i>';
        });
    </script>
</body>
</html>