@extends('layouts.app')

{{-- Judul Halaman --}}
@section('content_header')
    <h1>Dashboard</h1>
@endsection

{{-- Konten Halaman --}}
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang, {{ Auth::user()->nama }}!</h3>
    </div>
    <div class="card-body">
        <p>Terima kasih telah menggunakan layanan kami.</p>
        <p>Gunakan menu di sidebar untuk memesan laundry atau melihat riwayat pesanan Anda.</p>
        <a href="#" class="btn btn-primary mt-3">
            <i class="fas fa-plus-circle"></i> Pesan Laundry Sekarang
        </a>
    </div>
</div>
@endsection