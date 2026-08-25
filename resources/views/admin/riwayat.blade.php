@extends('admin.admin')

@section('main-content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white">
                <i class="fas fa-clock-rotate-left text-info me-2"></i> Riwayat Pembelian
            </h2>
            <p class="text-muted small mb-0">Daftar transaksi yang sudah dikonfirmasi.</p>
        </div>
        <span class="badge px-3 py-2 shadow-sm" style="background: #2563eb; border-radius: 12px; font-weight: 700; color: #ffffff;">
            Total: {{ count($belis) }} Transaksi
        </span>
    </div>

    <div class="card border-0 shadow-lg" style="background: #0f172a; border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #1e293b;">
                    <tr>
                        <th class="py-4 px-4 text-center text-secondary">NO</th>
                        <th class="py-4 text-secondary">PEMBELI & EMAIL</th>
                        <th class="py-4 text-secondary">KONTAK</th>
                        <th class="py-4 text-secondary">NAMA MOBIL</th>
                        <th class="py-4 text-secondary">TANGGAL</th>
                        <th class="py-4 text-secondary">ALAMAT & KOTA</th>
                        <th class="py-4 text-center text-secondary">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($belis as $item)
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <td class="px-4 text-center fw-bold text-secondary">#{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->nama }}</div>
                            <div class="small text-secondary">{{ $item->email }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background: #dcfce7; color: #166534;">{{ $item->no_telepon }}</span>
                        </td>
                        <td class="fw-bold text-dark">{{ $item->nama_mobil }}</td>
                        <td>
                            <div class="fw-bold text-dark" style="white-space: nowrap;">{{ $item->created_at->format('d/m/Y') }}</div>
                            <small class="text-secondary">{{ $item->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td class="text-dark">
                            <div><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $item->alamat }}</div>
                            <small class="badge bg-secondary">{{ strtoupper($item->kota) }}</small>
                        </td>
                        <td class="text-center"><span class="badge bg-success">Selesai</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="fas fa-inbox d-block mb-3" style="font-size: 2.5rem;"></i>
                            Belum ada transaksi yang selesai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
