@extends('admin.admin')

@section('main-content')
<div class="container-fluid p-4">
    {{-- Header --}}
    <div class="mb-4">
        <a href="{{ route('admin.pembelian') }}" class="text-decoration-none text-muted small">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <h2 class="fw-bold mt-2 text-white">
            <i class="fas fa-edit text-warning me-2"></i> Edit Transaksi
        </h2>
        <p class="text-muted small">Perbarui data informasi pembeli secara akurat.</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Form Card --}}
            <div class="card border-0 shadow-lg" style="background: #0f172a; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body p-4">
                    <form action="{{ route('beli.update', $beli->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama Pembeli --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50 small fw-bold">NAMA PEMBELI</label>
                                <input type="text" name="nama" class="form-control bg-dark border-secondary text-white p-3" 
                                       style="border-radius: 12px;" value="{{ old('nama', $beli->nama) }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50 small fw-bold">EMAIL</label>
                                <input type="email" name="email" class="form-control bg-dark border-secondary text-white p-3" 
                                       style="border-radius: 12px;" value="{{ old('email', $beli->email) }}" required>
                            </div>

                            {{-- No Telepon --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50 small fw-bold">NO. TELEPON / WHATSAPP</label>
                                <input type="text" name="no_telepon" class="form-control bg-dark border-secondary text-white p-3" 
                                       style="border-radius: 12px;" value="{{ old('no_telepon', $beli->no_telepon) }}" required>
                            </div>

                            {{-- Kota --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50 small fw-bold">KOTA</label>
                                <input type="text" name="kota" class="form-control bg-dark border-secondary text-white p-3" 
                                       style="border-radius: 12px;" value="{{ old('kota', $beli->kota) }}" required>
                            </div>

                            {{-- Alamat Lengkap --}}
                            <div class="col-12 mb-4">
                                <label class="form-label text-white-50 small fw-bold">ALAMAT LENGKAP</label>
                                <textarea name="alamat" class="form-control bg-dark border-secondary text-white p-3" 
                                          style="border-radius: 12px;" rows="3" required>{{ old('alamat', $beli->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 10px;">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-5 py-2" style="background: #2563eb; border: none; border-radius: 10px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Card (Optional) --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg p-3" style="background: #1e293b; border-radius: 20px; color: #94a3b8;">
                <div class="d-flex align-items-center mb-3 text-white">
                    <i class="fas fa-info-circle me-2"></i> <h6 class="mb-0 fw-bold">Informasi Kendaraan</h6>
                </div>
                <p class="small mb-1">Mobil yang dipesan:</p>
                <h5 class="text-info fw-bold">{{ $beli->nama_mobil }}</h5>
                <hr style="border-color: rgba(255,255,255,0.1);">
                <p class="small italic">Terdaftar pada: <br> {{ $beli->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #1a1a1a !important;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        color: white;
    }
    label {
        letter-spacing: 1px;
    }
</style>
@endsection