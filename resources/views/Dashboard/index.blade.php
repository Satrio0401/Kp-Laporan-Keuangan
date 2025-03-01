@extends('Layouts.main')

@section('Content')

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Hi, welcome back!</h4>
            <p class="mb-0">Your business dashboard template</p>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Blank</a></li>
        </ol>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-5">
        <label for="filterYear">Pilih Tahun:</label>
        <select id="filterYear" class="form-control">
            <option value="2024">2024</option>
            <option value="2025" selected>2025</option>
            <option value="2026">2026</option>
        </select>
    </div>
</div>

{{-- Row untuk menampilkan Total Pemasukan & Pengeluaran --}}
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-money text-success border-success"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total Pemasukan per Bulan</div>
                    <div class="stat-digit" id="totalPemasukanBulan">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-money text-danger border-danger"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total Pengeluaran per Bulan</div>
                    <div class="stat-digit" id="totalPengeluaranBulan">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-money text-success border-success"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total Pemasukan per Tahun</div>
                    <div class="stat-digit" id="totalPemasukanTahun">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-money text-danger border-danger"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total Pengeluaran per Tahun</div>
                    <div class="stat-digit" id="totalPengeluaranTahun">0</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pemasukan & Pengeluaran</h4>
            </div>
            <div class="card-body">
                <canvas id="financeChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan Chart.js langsung di dalam template ini --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var ctx = document.getElementById('financeChart').getContext('2d');

        var financeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                datasets: [
                    {
                        label: "Pemasukan",
                        data: [], // Data akan diisi dari API
                        backgroundColor: "rgba(54, 162, 235, 0.7)",
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 1
                    },
                    {
                        label: "Pengeluaran",
                        data: [], // Data akan diisi dari API
                        backgroundColor: "rgba(255, 99, 132, 0.7)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 1
                    }
                ]
            }
        });

        function fetchChartData(year) {
            fetch(`/chart-data?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    financeChart.data.datasets[0].data = data.pemasukan;
                    financeChart.data.datasets[1].data = data.pengeluaran;
                    financeChart.update();

                    // Update total pemasukan & pengeluaran di UI
                    document.getElementById('totalPemasukanBulan').innerText = formatRupiah(data.totalPemasukanBulan);
                    document.getElementById('totalPengeluaranBulan').innerText = formatRupiah(data.totalPengeluaranBulan);
                    document.getElementById('totalPemasukanTahun').innerText = formatRupiah(data.totalPemasukanTahun);
                    document.getElementById('totalPengeluaranTahun').innerText = formatRupiah(data.totalPengeluaranTahun);
                });
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        // Ambil data awal untuk tahun default (2024)
        fetchChartData(2025);

        document.getElementById('filterYear').addEventListener('change', function () {
            fetchChartData(this.value);
        });

    });
</script>



@endsection
