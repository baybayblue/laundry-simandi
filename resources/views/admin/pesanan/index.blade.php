@extends('layouts.app')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Manajemen Pesanan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pesanan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Semua Pesanan</h3>
        <div class="card-tools">
            <a href="{{ route('admin.pesanan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pesanan Baru
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Invoice</th>
                    <th>Pelanggan</th>
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
                        {{-- Tampilkan nama user, jika user tidak ada (sudah dihapus), tampilkan 'Pelanggan Dihapus' --}}
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
                        <td>
                            <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="btn btn-info btn-xs"><i class="fas fa-eye"></i> Detail</a>
                            <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.pesanan.destroy', $pesanan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pesanan.</td>
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
