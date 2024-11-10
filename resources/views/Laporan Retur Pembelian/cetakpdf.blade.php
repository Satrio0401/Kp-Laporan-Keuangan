<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Retur Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .title {
            text-align: center;
            margin-bottom: 15px;
        }

        .title h2 {
            margin: 0;
            color: #444;
            font-size: 20px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            padding: 10px; /* Menambah margin di dalam sel */
            text-align: left;
            font-size: 12px; /* Memperbesar ukuran font isi tabel */
        }

        .main-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px; /* Memperbesar ukuran font header tabel */
        }

        .main-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .summary-section {
            margin-top: 20px;
            border-top: 2px solid #444;
            padding-top: 15px;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="title">
        <h2>Laporan Retur Pembelian</h2>
        {{-- <h5>Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h5> --}}
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Faktur</th>
                <th>Tanggal Pengembalian</th>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Total Faktur</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $totalJumlah = 0; // Inisialisasi totalJumlah
            @endphp
            @foreach($returPembelian as $item)
                <tr>
                    <td scope="laporankeuangan">{{ $no++ }}</td>
                    <td>{{ $item->no_faktur }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_retur)->format('d/m/Y') }}</td>
                    <td>{{ $item->supplier->nama ?? '-' }}</td>
                    <td>{{ $item->pembelian->nama_barang ?? 'N/A' }}</td>
                    <td>{{ $item->jumlah_dikembalikan }}</td>
                    @php
                // Memeriksa status untuk menentukan subtotal
                if ($item->status === 'diterima') {
                    $subtotal = $item->jumlah_dikembalikan * ($item->pembelian->harga_satuan ?? 0);
                    $totalJumlah += $subtotal; // Tambahkan subtotal ke totalJumlah hanya jika diterima
                } else {
                    $subtotal = 0; // Set subtotal ke 0 jika statusnya "pending" atau "ditolak"
                }
            @endphp
            <td>{{ formatRupiah($subtotal) }}</td> <!-- Menampilkan subtotal untuk setiap item -->
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="6"><strong>TOTAL</strong></td>
                    <td colspan="2"><strong>{{ formatRupiah($totalJumlah) }}</strong></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>

</html>
