<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pendapatan</title>
    {{-- Menggunakan Bootstrap CDN untuk styling tabel dasar --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .total-row {
            font-weight: bold;
        }
        @page {
            size: A4;
            margin: 0.5in;
        }
        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pendapatan Laundry</h2>
        <h4>Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</h4>
    </div>

    <p>Total Pendapatan pada periode ini adalah: <strong>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></p>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Invoice</th>
                <th>Pelanggan</th>
                <th>Tanggal Masuk</th>
                <th>Status</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanans as $pesanan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $pesanan->kode_invoice }}</td>
                    <td>{{ $pesanan->user->nama ?? 'Pelanggan Dihapus' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($pesanan->tanggal_masuk)->translatedFormat('d/m/Y') }}</td>
                    <td class="text-center">{{ $pesanan->status }}</td>
                    <td class="text-right">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pesanan pada rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right">Total Pendapatan:</td>
                <td class="text-right">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <script>
        // Memicu dialog cetak secara otomatis saat halaman dimuat
        window.print();
    </script>
</body>
</html>
