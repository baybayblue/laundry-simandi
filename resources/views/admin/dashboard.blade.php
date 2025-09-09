@extends('layouts.app')

{{-- Judul Halaman --}}
@section('content_header')
    <h1>Dashboard Admin</h1>
@endsection

{{-- Konten Halaman --}}
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang, {{ Auth::user()->nama }}!</h3>
    </div>
    <div class="card-body">
        <p>Anda telah berhasil login sebagai **Admin**.</p>
        <p>Silakan gunakan menu di sidebar sebelah kiri untuk mulai mengelola data aplikasi laundry.</p>
    </div>
</div>
@endsection