<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GY-Techautocar Admin Panel</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-deep: #020617;
            --bg-surface: #08192f;
            --accent-main: #2563eb;
            --accent-highlight: #facc15;
            --text-main: #eef2ff;
            --text-muted: #cbd5e1;
            --border-soft: rgba(255, 255, 255, 0.08);
            --glass: rgba(15, 23, 42, 0.82);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top, #081029 0%, #020617 65%, #000000 100%);
            color: var(--text-main);
            margin: 0;
            letter-spacing: -0.2px;
            min-height: 100vh;
        }

        .sidebar {
            height: 100vh;
            width: 270px;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #061530 0%, #081f41 100%);
            border-right: 1px solid var(--border-soft);
            z-index: 1050;
            transition: all 0.35s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 2.5rem 1.8rem;
            font-weight: 800;
            font-size: 1.65rem;
            line-height: 1.1;
            background: linear-gradient(90deg, #facc15 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
        }

        .sidebar nav {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 2rem;
        }

        .sidebar a {
            color: var(--text-muted);
            text-decoration: none;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            margin: 6px 16px;
            border-radius: 16px;
            font-weight: 600;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .sidebar a i {
            font-size: 1.1rem;
            margin-right: 12px;
            transition: color 0.25s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(250, 204, 21, 0.12);
            color: var(--accent-highlight);
            transform: translateX(6px);
        }

        .sidebar a.active i,
        .sidebar a:hover i {
            color: var(--accent-highlight);
        }

        .main-container {
            margin-left: 270px;
            min-height: 100vh;
            transition: margin-left 0.35s ease;
        }

        .navbar {
            background: var(--glass);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1.2rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .text-muted {
            color: #94a3b8 !important;
        }

        .navbar .text-white {
            color: #eef2ff !important;
        }

        .modal-content {
            background: #0b1632 !important;
            border: 1px solid rgba(37, 99, 235, 0.22);
            border-radius: 28px;
            padding: 1.3rem;
            box-shadow: 0 0 65px rgba(0, 0, 0, 0.7);
            animation: modalSlide 0.4s ease-out;
        }

        @keyframes modalSlide {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header { border: none; padding-bottom: 0; }
        .modal-title { font-weight: 800; font-size: 1.6rem; letter-spacing: -0.5px; }
        .btn-close { filter: invert(1); opacity: 0.65; }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent-highlight);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-control {
            background: rgba(5, 18, 45, 0.92) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 16px;
            color: #eef2ff !important;
            padding: 14px 18px;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-main) !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.14);
            background: #071224 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            border: none;
            border-radius: 16px;
            padding: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 12px 26px rgba(37, 99, 235, 0.28);
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(37, 99, 235, 0.35);
        }

        .stat-card {
            background: linear-gradient(145deg, #0f172a, #081730);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2rem;
            transition: 0.35s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent-main);
        }

        .btn-toggle-sidebar {
            display: none;
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 2000;
            background: linear-gradient(135deg, #2563eb, #facc15);
            color: #0f172a;
            border: none;
            width: 58px;
            height: 58px;
            border-radius: 18px;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.3);
        }

        .btn-toggle-sidebar i { font-size: 1.2rem; }

        .content-area {
            max-width: 1400px;
            margin: 0 auto;
        }

        .main-container .navbar {
            border-radius: 22px;
            margin: 12px 20px 0;
        }

        .sidebar-scroll {
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-container { margin-left: 0; }
            .btn-toggle-sidebar { display: block; }
            .navbar { padding: 1rem 1.2rem; }
            .main-container .navbar { margin: 0; border-radius: 0; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 100%; }
            .sidebar-brand { font-size: 1.4rem; padding: 1.8rem 1.4rem; }
            .sidebar a { margin: 6px 14px; padding: 12px 18px; }
            .main-container .navbar { padding: 1rem 1rem; }
            .btn-toggle-sidebar { right: 18px; bottom: 18px; }
            .content-area { padding: 0 18px; }
            .navbar .text-end { display: none !important; }
        }

        @media (max-width: 576px) {
            .btn-toggle-sidebar { width: 54px; height: 54px; }
            .sidebar { padding-top: 1.2rem; }
            .sidebar a { font-size: 0.95rem; }
            .main-container { min-height: 100vh; }
        }
    </style>
</head>
<body>

    <button class="btn-toggle-sidebar" id="btnToggle">
        <i class="fas fa-bars-staggered"></i>
    </button>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand text-center">
            GY-TECHautocar
        </div>
        
        <nav class="mt-2 flex-grow-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-grid-2 me-2"></i> Dashboard
            </a>
            <a href="{{ route('mobil.index') }}" class="{{ request()->is('mobil*') ? 'active' : '' }}">
                <i class="fas fa-car-rear me-2"></i> Data Kendaraan
            </a>
            <a href="{{ route('admin.pembelian') }}" class="{{ request()->is('admin/pembelian*') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> Data Pelanggan
            </a>
            <a href="{{ route('manage-admin.index') }}" class="{{ request()->is('manage-admin*') ? 'active' : '' }}">
                <i class="fas fa-user-gear me-2"></i> Staff Akses
            </a>
            <a href="{{ route('admin.riwayat') }}" class="{{ request()->is('admin/riwayat*') ? 'active' : '' }}">
                <i class="fas fa-clock-rotate-left me-2"></i> Riwayat
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