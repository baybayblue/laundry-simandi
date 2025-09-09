@extends('layouts.app')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Riwayat Pesanan Saya</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('pengguna.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Riwayat Pesanan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pesanan Anda</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Invoice</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $pesanan)
                    <tr>
                        <td>{{ $loop->iteration + $pesanans->firstItem() - 1 }}</td>
                        <td>{{ $pesanan->kode_invoice }}</td>
                        <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_masuk)->translatedFormat('d F Y, H:i') }}</td>
                        <td>
                            @php
                                $statusClass = '';
                                switch ($pesanan->status) {
                                    case 'Baru': $statusClass = 'badge-primary'; break;
                                    case 'Proses': $statusClass = 'badge-info'; break;
                                    case 'Selesai': $statusClass = 'badge-success'; break;
                                    case 'Diambil': $statusClass = 'badge-secondary'; break;
                                }
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ $pesanan->status }}</span>
                        </td>
                        <td>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pengguna.pesanan.show', $pesanan->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i> Lihat Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Anda belum memiliki riwayat pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{-- Menampilkan link paginasi --}}
        {{ $pesanans->links() }}
    </div>
</div>
@endsection
