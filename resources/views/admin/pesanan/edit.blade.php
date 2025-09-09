@extends('layouts.app')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Status Pesanan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pesanan.index') }}">Pesanan</a></li>
                <li class="breadcrumb-item active">Edit Status</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Update Status untuk Invoice #{{ $pesanan->kode_invoice }}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Pelanggan:</strong> {{ $pesanan->user->nama }}</p>
                    <p><strong>Tanggal Masuk:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_masuk)->translatedFormat('d F Y') }}</p>
                    <p><strong>Total Harga:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Ubah Status Pesanan</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Baru" {{ $pesanan->status == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Proses" {{ $pesanan->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Diambil" {{ $pesanan->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
