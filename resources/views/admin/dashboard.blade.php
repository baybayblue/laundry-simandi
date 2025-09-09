@extends('layouts.app')

@push('styles')
<style>
    .info-box {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Selamat Datang, {{ Auth::user()->nama ?? 'Pengguna' }}!</h1>
            <small class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</small>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- Baris untuk Info Box --}}
    <div class="row">
        {{-- Pendapatan Hari Ini --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                    <p>Pendapatan Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ route('admin.laporan.index', ['tanggal_awal' => now()->toDateString(), 'tanggal_akhir' => now()->toDateString()]) }}" class="small-box-footer">Lihat Laporan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- Pesanan Masuk Hari Ini --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $pesananHariIni }}</h3>
                    <p>Pesanan Masuk Hari Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <a href="{{ route('admin.pesanan.index') }}" class="small-box-footer">Lihat Pesanan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- Pesanan Sedang Diproses --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $pesananDiproses }}</h3>
                    <p>Pakaian Sedang Diproses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                 <a href="{{ route('admin.pesanan.index') }}" class="small-box-footer">Lihat Pesanan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        {{-- Total Pelanggan --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalPelanggan }}</h3>
                    <p>Total Pelanggan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.pelanggan.index') }}" class="small-box-footer">Lihat Pelanggan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Kolom untuk Pesanan Terbaru --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-history mr-2"></i>5 Pesanan Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm btn-primary">Lihat Semua Pesanan</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover m-0">
                            <thead>
                                <tr>
                                    <th>Kode Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pesananTerbaru as $pesanan)
                                <tr>
                                    <td><a href="{{ route('admin.pesanan.show', $pesanan->id) }}">{{ $pesanan->kode_invoice }}</a></td>
                                    <td>{{ $pesanan->user->nama ?? 'N/A' }}</td>
                                    {{-- PERBAIKAN: Menggunakan Carbon::parse untuk memastikan variabel adalah objek tanggal --}}
                                    <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_masuk)->translatedFormat('d M Y, H:i') }}</td>
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
                                    <td colspan="5" class="text-center py-4">Belum ada pesanan masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

