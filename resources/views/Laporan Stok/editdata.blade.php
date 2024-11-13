@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Edit Data Stok Barang</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ url('/LaporanStok/updatedata/'.$stoks->kode_barang) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kode_barang">Kode Barang
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="kode_barang" class="form-control" id="kode_barang" placeholder="Masukkan Kode Barang" value="{{ $stoks->kode_barang }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_barang">Nama Barang
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" value="{{ $stoks->nama_barang }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="jumlah_tersedia">Stok
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah_tersedia" class="form-control" id="jumlah_tersedia" placeholder="Masukkan Jumlah Stok" value="{{ $stoks->jumlah_tersedia }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <a href="/LaporanStok" class="btn btn-secondary">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
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
