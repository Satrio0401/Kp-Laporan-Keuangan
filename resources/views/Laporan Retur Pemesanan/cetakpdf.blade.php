<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Retur Penjualan<< /title>
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
                    padding: 10px;
                    /* Menambah margin di dalam sel */
                    text-align: left;
                    font-size: 12px;
                    /* Memperbesar ukuran font isi tabel */
                }

                .main-table th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                    text-transform: uppercase;
                    font-size: 11px;
                    /* Memperbesar ukuran font header tabel */
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
        <h2>Laporan Retur Penjualan</h2>
        {{-- <h5>Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h5> --}}
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Faktur</th>
                <th>Tanggal Retur</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Total Faktur</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($returPemesanan as $item)
                <tr>
                    <td scope="laporankeuangan">{{ $no++ }}</td>
                    <td>{{ $item->no_faktur }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_retur)->format('d/m/Y') }}</td>
                    <td>{{ $item->menu->nama ?? 'N/A' }}</td>
                    <td>{{ $item->jumlah_dikembalikan ?? 'N/A' }}</td>
                    @php
                        // Hitung total retur berdasarkan harga menu dan jumlah dikembalikan
                        $totalRetur = 0;
                        if ($item->status == 'diterima') {
                            $totalRetur = ($item->jumlah_dikembalikan ?? 0) * ($item->menu->harga ?? 0);
                        }
                        $totalJumlah += $totalRetur; // Tambahkan ke total jumlah
                    @endphp
                    <td>{{ formatRupiah($totalRetur) }}</td> <!-- Menampilkan subtotal untuk setiap item -->
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        <tfoot>
            <tr>
                <td colspan="5"><strong>TOTAL</strong></td>
                <td colspan="2"><strong>{{ formatRupiah($totalJumlah) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
