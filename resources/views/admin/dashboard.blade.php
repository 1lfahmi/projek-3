@extends('admin.admin')

@section('total-mobil', $totalMobil)
@section('total-pesanan', $totalPesanan)
@section('total-staff', $totalUser)

@section('main-content')
    <div class="mt-2">
        <div class="position-relative p-5 shadow-lg" 
             style="background: linear-gradient(135deg, #1e293b 0%, #020617 100%); 
                    border-radius: 30px; 
                    border: 2px solid rgba(56, 189, 248, 0.3);
                    box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;">
            
            <div class="row align-items-center position-relative">
                <div class="col-md-9">
                    <div class="mb-3">
                        <span class="badge bg-info text-dark fw-bold px-3 py-2" style="font-size: 0.8rem; letter-spacing: 1px;">
                            <i class="fas fa-signal me-2"></i> SISTEM ONLINE
                        </span>
                    </div>

                    <h1 class="fw-800 text-white mb-2" style="font-size: 3rem; letter-spacing: -1px; text-shadow: 2px 2px 10px rgba(0,0,0,0.8);">
                        Halo, <span class="text-info">{{ Auth::user()->name }}!</span>
                    </h1>
                    
                    <p class="text-white opacity-100 fs-5 mb-4" style="font-weight: 500; max-width: 600px; line-height: 1.6; text-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                        Manajemen kendaraan Anda siap dikelola. Database telah diperbarui dan sinkron dengan 
                        <b class="text-info border-bottom border-info">{{ $totalMobil }} unit armada</b> saat ini.
                    </p>
                    
                    <div class="d-flex flex-wrap gap-3">
                        <div class="p-3 rounded-4 d-flex align-items-center" style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981;">
                            <div class="bg-success rounded-circle me-3 animate-pulse" style="width: 12px; height: 12px; box-shadow: 0 0 15px #10b981;"></div>
                            <span class="text-white fw-bold">DATABASE TERHUBUNG</span>
                        </div>
                        <div class="p-3 rounded-4 d-flex align-items-center" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255,255,255,0.3);">
                            <i class="fas fa-shield-check text-info me-2"></i>
                            <span class="text-white fw-bold">KEAMANAN TINGGI</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 d-none d-md-block text-center">
                    <div class="display-1 text-info opacity-50">
                        <i class="fas fa-rocket"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 g-4">
            @php
                $visitorChange = $visitorPreviousMonth > 0 ? (($visitorThisMonth - $visitorPreviousMonth) / $visitorPreviousMonth) * 100 : ($visitorThisMonth > 0 ? 100 : 0);
                $purchaseChange = $purchasePreviousMonth > 0 ? (($purchaseThisMonth - $purchasePreviousMonth) / $purchasePreviousMonth) * 100 : ($purchaseThisMonth > 0 ? 100 : 0);
            @endphp
            <div class="col-md-3"><div class="p-4 rounded-4 h-100" style="background:#172554;border:1px solid #1d4ed8;"><small class="text-info fw-bold">PENGUNJUNG BULAN INI</small><h2 class="text-white fw-bold mt-2 mb-1">{{ number_format($visitorThisMonth) }}</h2><span class="{{ $visitorChange >= 0 ? 'text-success' : 'text-danger' }} fw-bold">{{ $visitorChange >= 0 ? '+' : '' }}{{ number_format($visitorChange, 1) }}% <small class="text-white-50">vs bulan lalu</small></span></div></div>
            <div class="col-md-3"><div class="p-4 rounded-4 h-100" style="background:#172554;border:1px solid #1d4ed8;"><small class="text-warning fw-bold">PEMBELIAN BULAN INI</small><h2 class="text-white fw-bold mt-2 mb-1">{{ number_format($purchaseThisMonth) }}</h2><span class="{{ $purchaseChange >= 0 ? 'text-success' : 'text-danger' }} fw-bold">{{ $purchaseChange >= 0 ? '+' : '' }}{{ number_format($purchaseChange, 1) }}% <small class="text-white-50">vs bulan lalu</small></span></div></div>
            <div class="col-md-3"><div class="p-4 rounded-4 h-100" style="background:#172554;border:1px solid #1d4ed8;"><small class="text-info fw-bold">KENDARAAN TERSEDIA</small><h2 class="text-white fw-bold mt-2 mb-1">{{ number_format($totalMobil) }}</h2><span class="text-white-50">Data katalog aktif</span></div></div>
            <div class="col-md-3"><div class="p-4 rounded-4 h-100" style="background:#172554;border:1px solid #1d4ed8;"><small class="text-warning fw-bold">TOTAL TRANSAKSI</small><h2 class="text-white fw-bold mt-2 mb-1">{{ number_format($totalPesanan) }}</h2><span class="text-white-50">Semua periode</span></div></div>
        </div>

        <div class="row mt-4 g-4">
            <div class="col-lg-8"><div class="p-4 rounded-4" style="background:#1e293b;border:1px solid rgba(255,255,255,.15);"><div class="d-flex justify-content-between align-items-center mb-3"><h4 class="text-white fw-bold m-0"><i class="fas fa-chart-line text-info me-2"></i>Pengunjung & Pembelian</h4><div class="btn-group btn-group-sm"><button class="btn btn-info" id="monthlyBtn">Bulanan</button><button class="btn btn-outline-light" id="yearlyBtn">Tahunan</button></div></div><canvas id="activityChart" height="110"></canvas></div></div>
            <div class="col-lg-4"><div class="p-4 rounded-4 h-100" style="background:#1e293b;border:1px solid rgba(255,255,255,.15);"><h4 class="text-white fw-bold mb-3"><i class="fas fa-chart-column text-warning me-2"></i>Tren Pembelian</h4><canvas id="purchaseChart" height="220"></canvas></div></div>
        </div>

        <div class="row mt-5 g-4">
            <div class="col-md-12">
                <div class="p-4" style="background: #1e293b; border-radius: 25px; border: 1px solid rgba(255,255,255,0.15);">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-white fw-800 m-0">
                            <i class="fas fa-chart-pie text-info me-2"></i> Ringkasan Aktivitas
                        </h4>
                        <span class="text-info fw-bold">Real-time Data</span>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 border border-secondary" style="background: rgba(255,255,255,0.05);">
                                <small class="text-info fw-bold d-block mb-1">LOG TERAKHIR</small>
                                <p class="text-white fw-bold m-0" style="font-size: 1.1rem;">
                                    <i class="fas fa-check-circle text-success me-2"></i> 
                                    Semua armada telah berhasil disinkronkan.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 border border-secondary" style="background: rgba(255,255,255,0.05);">
                                <small class="text-info fw-bold d-block mb-1">KESEHATAN SERVER</small>
                                <p class="text-white fw-bold m-0" style="font-size: 1.1rem;">
                                    <i class="fas fa-server text-info me-2"></i> 
                                    Latensi: 24ms (Sangat Cepat)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($chartLabels);
        const purchases = @json($purchaseChart);
        const visitors = @json($visitorChart);
        const yearlyLabels = @json($years);
        const yearlyPurchases = @json($yearlyPurchaseChart);
        const yearlyVisitors = @json($yearlyVisitorChart);
        const chartOptions = { responsive: true, plugins: { legend: { labels: { color: '#e2e8f0' } } }, scales: { x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,.06)' } }, y: { beginAtZero: true, ticks: { color: '#94a3b8', precision: 0 }, grid: { color: 'rgba(255,255,255,.06)' } } } };
        const activityChart = new Chart(document.getElementById('activityChart'), { type: 'line', data: { labels, datasets: [{ label: 'Pengunjung', data: visitors, borderColor: '#22d3ee', backgroundColor: 'rgba(34,211,238,.15)', fill: true, tension: .35 }, { label: 'Pembelian', data: purchases, borderColor: '#facc15', backgroundColor: 'rgba(250,204,21,.1)', fill: true, tension: .35 }] }, options: chartOptions });
        const purchaseChart = new Chart(document.getElementById('purchaseChart'), { type: 'bar', data: { labels, datasets: [{ label: 'Transaksi', data: purchases, backgroundColor: '#38bdf8', borderRadius: 5 }] }, options: chartOptions });
        function setPeriod(period) { const yearly = period === 'yearly'; activityChart.data.labels = yearly ? yearlyLabels : labels; activityChart.data.datasets[0].data = yearly ? yearlyVisitors : visitors; activityChart.data.datasets[1].data = yearly ? yearlyPurchases : purchases; purchaseChart.data.labels = yearly ? yearlyLabels : labels; purchaseChart.data.datasets[0].data = yearly ? yearlyPurchases : purchases; activityChart.update(); purchaseChart.update(); document.getElementById('monthlyBtn').className = yearly ? 'btn btn-outline-light' : 'btn btn-info'; document.getElementById('yearlyBtn').className = yearly ? 'btn btn-info' : 'btn btn-outline-light'; }
        document.getElementById('monthlyBtn').addEventListener('click', () => setPeriod('monthly'));
        document.getElementById('yearlyBtn').addEventListener('click', () => setPeriod('yearly'));
    </script>

    <style>
        .fw-800 { font-weight: 800 !important; }
        
        .animate-pulse {
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
@endsection