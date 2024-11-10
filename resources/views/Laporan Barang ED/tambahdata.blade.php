@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Barang ED</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanBarangED/tambahdata/insertdata" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kode_barang">Kode Barang</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_barang">Nama Barang</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="jumlah_barang">Jumlah Barang</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah_barang" class="form-control" id="jumlah_barang" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_masuk">Tanggal Masuk</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-right">
                                        <a href="/LaporanBarangED" class="btn btn-secondary">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    

@endsection
