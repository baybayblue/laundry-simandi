@extends('layouts.app')

{{-- Judul Halaman --}}
@section('content_header')
    <h1>Manajemen Pelanggan</h1>
@endsection

{{-- Konten Halaman --}}
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pelanggan Terdaftar</h3>
        <div class="card-tools">
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nama</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Tgl. Bergabung</th>
                        <th style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <tr>
                            <td>{{ $loop->iteration + $pelanggans->firstItem() - 1 }}.</td>
                            <td>{{ $pelanggan->nama }}</td>
                            <td>{{ $pelanggan->nomor_hp }}</td>
                            <td>{{ Str::limit($pelanggan->alamat, 50) }}</td>
                            <td>{{ $pelanggan->created_at->translatedFormat('d F Y') }}</td>
                            <td>
                                <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" class="btn btn-xs btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- PERBAIKAN: Menggunakan SweetAlert untuk konfirmasi hapus --}}
                                <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" method="POST" class="d-inline" id="delete-form-{{ $pelanggan->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete('delete-form-{{ $pelanggan->id }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{-- Link Paginasi --}}
        {{ $pelanggans->links() }}
    </div>
</div>
@endsection

@push('scripts')
{{-- Script untuk konfirmasi hapus dengan SweetAlert --}}
<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data pelanggan ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, submit form penghapusan
                document.getElementById(formId).submit();
            }
        })
    }
</script>
@endpush

