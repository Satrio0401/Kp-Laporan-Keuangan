<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran</title>
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
        <h2>Laporan Pengeluaran</h2>
        {{-- <h5>Periode {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h5> --}}
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Faktur</th>
                <th>Tanggal Pembelian</th>
                <th>Supplier Name</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($Pengeluarans as $Pengeluaran)
                <tr>
                    <td scope="laporankeuangan">{{$no++}}</td>
                    <td>{{ $Pengeluaran->kode_biaya }}</td>
                    <td>{{ $Pengeluaran->tanggal_pengeluaran }}</td>
                    <td>{{ $Pengeluaran->biaya_untuk }}</td>
                    <td>{{ formatRupiah($Pengeluaran->total_pengeluaran )}}</td>
                </tr>
            @endforeach
            <tfoot>
                <tr>
                    <td colspan="4"><strong>TOTAL</strong></td>
                    <td><strong>{{ formatRupiah($totalBiaya) }}</strong></td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</body>

</html>
