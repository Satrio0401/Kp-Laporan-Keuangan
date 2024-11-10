@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Data Stok Barang</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanStok/tambahdata/insertdata" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kode_barang">Kode Barang
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="kode_barang" class="form-control" id="kode_barang"  required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_barang">Nama Barang
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="harga_barang">Harga Barang 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="harga_barang" class="form-control" id="harga_barang"  required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="stok_barang">Stok
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah_tersedia" class="form-control" id="jumlah_tersedia"  required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-right">
                                        <a href="/LaporanStok" class="btn btn-secondary">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
