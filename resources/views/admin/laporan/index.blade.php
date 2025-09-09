@extends('layouts.app')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Laporan Pendapatan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Laporan</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.laporan.index') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ $tanggalAwal }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-group w-100">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Pendapatan dari <strong>{{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</strong></h3>
        <div class="card-tools">
            {{-- Form untuk tombol cetak, agar filter tanggal ikut terkirim --}}
            <form action="{{ route('admin.laporan.cetak') }}" method="GET" target="_blank">
                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </form>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="alert alert-success">
            <h4>Total Pendapatan: Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanans as $pesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.pesanan.show', $pesanan->id) }}">{{ $pesanan->kode_invoice }}</a>
                            </td>
                            <td>{{ $pesanan->user->nama ?? 'Pelanggan Dihapus' }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pesanan pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                 <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Total Pendapatan:</th>
                        <th>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>
@endsection
