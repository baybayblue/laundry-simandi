@extends('layouts.app')

@push('styles')
    {{-- Tambahkan Select2 untuk dropdown yang lebih baik --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
    </style>
@endpush

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Pesanan Baru</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.pesanan.index') }}">Pesanan</a></li>
                <li class="breadcrumb-item active">Tambah Baru</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.pesanan.store') }}" method="POST">
    @csrf
    <div class="row">
        {{-- Kolom Kiri: Info Utama Pesanan --}}
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pesanan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="kode_invoice">Kode Invoice</label>
                        <input type="text" class="form-control" id="kode_invoice" name="kode_invoice" value="{{ $kode_invoice }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_user">Pilih Pelanggan</label>
                        <select class="form-control select2 @error('id_user') is-invalid @enderror" id="id_user" name="id_user" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}" {{ old('id_user') == $pelanggan->id ? 'selected' : '' }}>
                                    {{ $pelanggan->nama }} - {{ $pelanggan->nomor_hp }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="berat">Berat (Kg)</label>
                        <input type="number" step="0.1" class="form-control @error('berat') is-invalid @enderror" id="berat" name="berat" value="{{ old('berat') }}" placeholder="Opsional, isi jika ada layanan kiloan">
                         @error('berat')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Detail Layanan --}}
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Layanan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="layanan_select">Pilih Layanan</label>
                        <select id="layanan_select" class="form-control select2">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach ($layanans as $layanan)
                                <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}" data-satuan="{{ $layanan->satuan }}">
                                    {{ $layanan->nama_layanan }} (Rp{{ number_format($layanan->harga, 0, ',', '.') }}/{{$layanan->satuan}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" id="jumlah" class="form-control" placeholder="Masukkan jumlah/kuantitas">
                    </div>
                    <button type="button" id="btn-tambah-layanan" class="btn btn-success float-right">Tambah Layanan ke Pesanan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Rincian Layanan --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rincian Pesanan</h3>
        </div>
        <div class="card-body table-responsive">
            @error('layanans')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="rincian-pesanan-body">
                    {{-- Layanan yang ditambahkan akan muncul di sini --}}
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total Harga:</th>
                        <th id="total-harga-display">Rp0</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            let totalHarga = 0;
            let layananCounter = 0;

            $('#btn-tambah-layanan').on('click', function() {
                const layananSelect = $('#layanan_select');
                const selectedOption = layananSelect.find('option:selected');
                const layananId = selectedOption.val();
                const layananNama = selectedOption.text().split(' (')[0];
                const layananHarga = parseFloat(selectedOption.data('harga'));
                const layananSatuan = selectedOption.data('satuan');
                const jumlah = parseFloat($('#jumlah').val());

                if (!layananId || !jumlah || isNaN(jumlah) || jumlah <= 0) {
                    alert('Silakan pilih layanan dan masukkan jumlah yang valid.');
                    return;
                }

                const subtotal = layananHarga * jumlah;

                const newRow = `
                    <tr data-id="${layananId}" data-subtotal="${subtotal}">
                        <td>
                            <input type="hidden" name="layanans[${layananCounter}][id]" value="${layananId}">
                            ${layananNama}
                        </td>
                        <td>
                            <input type="hidden" name="layanans[${layananCounter}][jumlah]" value="${jumlah}">
                            ${jumlah} ${layananSatuan}
                        </td>
                        <td>Rp${new Intl.NumberFormat('id-ID').format(layananHarga)}</td>
                        <td>Rp${new Intl.NumberFormat('id-ID').format(subtotal)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus-layanan">Hapus</button>
                        </td>
                    </tr>
                `;

                $('#rincian-pesanan-body').append(newRow);
                layananCounter++;
                updateTotalHarga();
                
                // Reset input
                layananSelect.val('').trigger('change');
                $('#jumlah').val('');
            });

            // Event handler untuk tombol hapus
            $('#rincian-pesanan-body').on('click', '.btn-hapus-layanan', function() {
                $(this).closest('tr').remove();
                updateTotalHarga();
            });

            function updateTotalHarga() {
                totalHarga = 0;
                $('#rincian-pesanan-body tr').each(function() {
                    totalHarga += parseFloat($(this).data('subtotal'));
                });
                $('#total-harga-display').text('Rp' + new Intl.NumberFormat('id-ID').format(totalHarga));
            }
        });
    </script>
@endpush
