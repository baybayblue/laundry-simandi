@extends('layouts.app')

{{-- Judul Halaman --}}
@section('content_header')
    <h1>Edit Pelanggan</h1>
@endsection

{{-- Konten Halaman --}}
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Formulir Edit Data Pelanggan</h3>
        <div class="card-tools">
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
    {{-- Form action menunjuk ke route update dengan parameter id pelanggan --}}
    <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Method spoofing untuk request UPDATE --}}
        <div class="card-body">
            {{-- Baris Nama --}}
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                {{-- Mengisi value dengan data lama atau data dari database --}}
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Baris Nomor HP --}}
            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $pelanggan->nomor_hp) }}" required>
                @error('nomor_hp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- PERBAIKAN: Menambahkan kolom Alamat --}}
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                @error('alamat')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <hr>
            <p class="text-muted">Kosongkan password jika tidak ingin mengubahnya.</p>
            
            {{-- Baris Password --}}
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Baris Konfirmasi Password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

