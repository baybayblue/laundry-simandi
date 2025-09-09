@extends('layouts.app')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Manajemen Layanan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Layanan</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Layanan Laundry</h3>
        <div class="card-tools">
            <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Layanan
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Durasi</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layanans as $index => $layanan)
                        <tr>
                            <td>{{ $layanans->firstItem() + $index }}</td>
                            <td>{{ $layanan->nama_layanan }}</td>
                            <td>Rp{{ number_format($layanan->harga, 0, ',', '.') }}</td>
                            <td>{{ $layanan->satuan }}</td>
                            <td>{{ $layanan->durasi }}</td>
                            <td>
                                <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.layanan.destroy', $layanan->id) }}" method="POST" class="d-inline form-hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        {{ $layanans->links() }}
    </div>
</div>
@endsection

@push('scripts')
{{-- Script untuk konfirmasi hapus menggunakan SweetAlert --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.form-hapus');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data layanan yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
