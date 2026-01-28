{{-- SESUAIKAN BAGIAN INI: Ganti 'layouts.admin' dengan nama layout asli kamu --}}
@extends('admin.admin') 

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Data Pembelian</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Kota</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelians as $p)
                        <tr>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->telepon }}</td>
                            <td>{{ $p->kota }}</td>
                            <td>{{ $p->alamat }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data masih kosong di database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection