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
            <div class="col-12">
                <div class="p-4 rounded-4" style="background:#1e293b;border:1px solid rgba(255,255,255,.15);">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div>
                            <h4 class="text-white fw-bold m-0">
                                <i class="fas fa-calendar-days text-info me-2"></i>Filter Periode Data
                            </h4>
                            <small class="text-slate-300">Pilih periode audit secara terstruktur untuk melihat aktivitas per bulan atau per tahun.</small>
                        </div>
                        <div class="text-info fw-bold">{{ $periodLabel }}</div>
                    </div>

                    <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 mt-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small mb-2">Jenis Periode</label>
                            <select name="period" class="form-select form-select-lg rounded-3 border-0 shadow-none" style="background:#0f172a;color:#e2e8f0;">
                                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-slate-300 small mb-2">Tahun</label>
                            <select name="year" class="form-select form-select-lg rounded-3 border-0 shadow-none" style="background:#0f172a;color:#e2e8f0;">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ (int) $selectedYear === (int) $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-info px-4 fw-bold rounded-3">
                                <i class="fas fa-filter me-2"></i>Terapkan
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light px-4 rounded-3">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8"><div class="p-4 rounded-4" style="background:#1e293b;border:1px solid rgba(255,255,255,.15);"><div class="d-flex justify-content-between align-items-center mb-3"><h4 class="text-white fw-bold m-0"><i class="fas fa-chart-line text-info me-2"></i>Pengunjung & Pembelian</h4><span class="badge bg-info text-dark fw-bold">{{ $period === 'yearly' ? 'Tahunan' : 'Bulanan' }}</span></div><canvas id="activityChart" height="110"></canvas></div></div>
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
                                <small class="text-info fw-bold d-block mb-2">BULAN PALING RAMAI</small>
                                <div class="d-flex align-items-center justify-content-between gap-3">
                                    <div style="width: 130px; height: 130px; position: relative;">
                                        <canvas id="topVisitorChart" width="130" height="130"></canvas>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="text-white fw-bold" style="font-size: 1.1rem;">{{ $topVisitorMonthLabel }}</div>
                                        <div class="text-info fw-bold mt-2">{{ number_format($topVisitorMonthValue) }} pengunjung</div>
                                    </div>
                                </div>
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
        const monthVisitorLabels = @json($yearlyMonthVisitorData->pluck('label')->values());
        const monthVisitorData = @json($yearlyMonthVisitorData->pluck('count')->values());
        const chartOptions = { responsive: true, plugins: { legend: { labels: { color: '#e2e8f0' } } }, scales: { x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,.06)' } }, y: { beginAtZero: true, ticks: { color: '#94a3b8', precision: 0 }, grid: { color: 'rgba(255,255,255,.06)' } } } };
        const activityChart = new Chart(document.getElementById('activityChart'), { type: 'line', data: { labels, datasets: [{ label: 'Pengunjung', data: visitors, borderColor: '#22d3ee', backgroundColor: 'rgba(34,211,238,.15)', fill: true, tension: .35 }, { label: 'Pembelian', data: purchases, borderColor: '#facc15', backgroundColor: 'rgba(250,204,21,.1)', fill: true, tension: .35 }] }, options: chartOptions });
        const purchaseChart = new Chart(document.getElementById('purchaseChart'), { type: 'bar', data: { labels, datasets: [{ label: 'Transaksi', data: purchases, backgroundColor: '#38bdf8', borderRadius: 5 }] }, options: chartOptions });

        const topVisitorChart = new Chart(document.getElementById('topVisitorChart'), {
            type: 'doughnut',
            data: {
                labels: monthVisitorLabels,
                datasets: [{
                    data: monthVisitorData,
                    backgroundColor: ['#22d3ee', '#38bdf8', '#2dd4bf', '#facc15', '#a78bfa', '#fb7185', '#f59e0b', '#34d399', '#60a5fa', '#f472b6', '#a3e635', '#f87171'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '58%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed} pengunjung`;
                            }
                        }
                    }
                }
            }
        });
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