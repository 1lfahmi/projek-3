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