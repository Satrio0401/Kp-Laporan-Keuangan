@extends('Layouts.main') 

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Edit Supplier</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/DaftarSupplier/updatedata/{{ $supplier->kode_supplier }}" method="POST">
                        @csrf
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-nama">Nama Supplier
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama" class="form-control" id="val-nama" value="{{ $supplier->nama }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-no_hp">No Telp
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="no_hp" class="form-control" id="val-no_hp" value="{{ $supplier->no_hp }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-email">Email
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="email" name="email" class="form-control" id="val-email" value="{{ $supplier->email }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-alamat">Alamat
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="alamat" class="form-control" id="val-alamat" value="{{ $supplier->alamat }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <a href="/DaftarSupplier" class="btn btn-secondary">Kembali</a>
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

@endsection
