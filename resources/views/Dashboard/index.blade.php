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

<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-one card-body">
                <div class="stat-icon d-inline-block">
                    <i class="ti-money text-success border-success"></i>
                </div>
                <div class="stat-content d-inline-block">
                    <div class="stat-text">Total Pemasukan per-bulan</div>
                    <div class="stat-digit">1,012</div>
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
                    <div class="stat-text">Total Pengeluaran per-bulan</div>
                    <div class="stat-digit">961</div>
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
                    <div class="stat-text">Total Pemasukan per-tahun</div>
                    <div class="stat-digit">770</div>
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
                    <div class="stat-text">Total Pengeluaran per-tahun</div>
                    <div class="stat-digit">1,012</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Fee Collections and Expenses</h4>
            </div>
            <div class="card-body">
                <div class="ct-bar-chart mt-5"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="ct-pie-chart"></div>
            </div>
        </div>
    </div>
</div>

    


@endsection