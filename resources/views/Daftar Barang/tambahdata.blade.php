@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Menu</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/DaftarMenu/tambahdata/insertdata" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama">Nama Menu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama" class="form-control" id="nama" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kategori">Kategori
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <select name="kategori" class="form-control" id="kategori">
                                            <option value="" disabled selected>Pilih Kategori</option>
                                            <option value="Makanan">Makanan</option>
                                            <option value="Minuman">Minuman</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="harga">Harga
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="harga" id="harga" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <a href="/DaftarMenu" class="btn btn-secondary">Kembali</a>
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
