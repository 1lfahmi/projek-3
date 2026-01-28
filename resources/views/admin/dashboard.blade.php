@extends('admin.admin') {{-- Menarik sidebar dari admin.blade.php --}}

@section('main-content')
    <h2 class="fw-bold mb-4">Dashboard Admin</h2>
    <p>Selamat datang, <b>{{ Auth::user()->name }}</b> 👋</p>
    
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow border-0 p-3 rounded-3">
                <h5 class="card-title opacity-75">Total Mobil</h5>
                <h2 class="fw-bold">{{ $totalMobil }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow border-0 p-3 rounded-3">
                <h5 class="card-title opacity-75">Total Pesanan</h5>
                <h2 class="fw-bold">{{ $totalPesanan }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow border-0 p-3 rounded-3">
                <h5 class="card-title opacity-75">Staff admin</h5>
                <h2 class="fw-bold">{{ $totalUser }}</h2>
            </div>
        </div>
    </div>
@endsection