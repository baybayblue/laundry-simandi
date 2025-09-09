@extends('layouts.app')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Pesanan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pesanan.index') }}">Pesanan</a></li>
                <li class="breadcrumb-item active">Detail Pesanan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-receipt"></i> Detail Invoice
                <small class="float-right">Tanggal Masuk: {{ \Carbon\Carbon::parse($pesanan->tanggal_masuk)->translatedFormat('d/m/Y') }}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Dari
            <address>
                <strong>Admin Laundry</strong><br>
                Jl. Contoh Alamat No. 123<br>
                Bandung, Jawa Barat<br>
                Telepon: (022) 123-4567
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Untuk
            <address>
                <strong>{{ $pesanan->user->nama }}</strong><br>
                {{ $pesanan->user->alamat }}<br>
                Telepon: {{ $pesanan->user->nomor_hp }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #{{ $pesanan->kode_invoice }}</b><br>
            <br>
            <b>ID Pesanan:</b> {{ $pesanan->id }}<br>
            <b>Status:</b>
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
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanan->detailPesanans as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->layanan->nama_layanan }}</td>
                            <td>Rp{{ number_format($detail->layanan->harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->jumlah }} {{ $detail->layanan->satuan }}</td>
                            <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Terima kasih telah menggunakan jasa kami. Harap periksa kembali barang bawaan Anda saat pengambilan.
            </p>
        </div>
        <!-- /.col -->
        <div class="col-6">
            <p class="lead">Ringkasan Pembayaran</p>

            <div class="table-responsive">
                <table class="table">
                    @if($pesanan->berat)
                    <tr>
                        <th style="width:50%">Berat Total:</th>
                        <td>{{ $pesanan->berat }} Kg</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Total:</th>
                        <td><strong>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-12">
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}" class="btn btn-warning float-right" style="margin-left: 5px;"><i class="fas fa-edit"></i> Edit Status</a>
            {{-- PERBAIKAN: Tombol Cetak diaktifkan dan diberi fungsi print --}}
            <button type="button" class="btn btn-primary float-right" onclick="window.print();">
                <i class="fas fa-print"></i> Cetak Invoice
            </button>
        </div>
    </div>
</div>
@endsection

