@extends('Layouts.main')

@section('Content')

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Hi, welcome back!</h4>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-5 ">
        <label for="filterYear">Pilih Tahun:</label>
        <select id="filterYear" class="form-control">
            <option value="2024">2024</option>
            <option value="2025" selected>2025</option>
            <option value="2026">2026</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card shadow-sm p-2">
            <div class="stat-widget-one card-body d-flex align-items-center">
                <div class="stat-content">
                    <div class="stat-text fw-semibold text-muted small">Total Pemasukan per Bulan</div>
                    <div class="stat-digit fw-bold fs-5 text-dark" id="totalPemasukanBulan">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card shadow-sm p-2">
            <div class="stat-widget-one card-body d-flex align-items-center">
                <div class="stat-content">
                    <div class="stat-text fw-semibold text-muted small">Total Pengeluaran per Bulan</div>
                    <div class="stat-digit fw-bold fs-5 text-dark" id="totalPengeluaranBulan">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card shadow-sm p-2">
            <div class="stat-widget-one card-body d-flex align-items-center">
                <div class="stat-content">
                    <div class="stat-text fw-semibold text-muted small">Total Pemasukan per Tahun</div>
                    <div class="stat-digit fw-bold fs-5 text-dark" id="totalPemasukanTahun">0</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="card shadow-sm p-2">
            <div class="stat-widget-one card-body d-flex align-items-center">
                <div class="stat-content">
                    <div class="stat-text fw-semibold text-muted small">Total Pengeluaran per Tahun</div>
                    <div class="stat-digit fw-bold fs-5 text-dark" id="totalPengeluaranTahun">0</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="row">
    <!-- Chart Batang (Pemasukan & Pengeluaran) -->
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

    <!-- Pie Chart (Menu Terlaris) -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Menu Terlaris Bulan Ini</h4>
            </div>
            <div class="card-body">
                <canvas id="menuPieChart"></canvas>
            </div>
        </div>
    </div>
</div> <!-- Tutup row dengan benar -->


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

    document.addEventListener("DOMContentLoaded", function () {
        var pieData = @json($penjualanPerBarang);

        var labels = pieData.map(item => item.nama);
        var values = pieData.map(item => item.total_terjual);
        var colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF9800'];

        var pieCtx = document.getElementById('menuPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors
                }]
            }
        });
    });

    
</script>



@endsection
