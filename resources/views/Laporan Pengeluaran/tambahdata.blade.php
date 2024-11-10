@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Validation</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanPengeluaran/tambahdata/insertdata"  method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-username">Kode Biaya</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="kode_biaya" class="form-control" id="val-username" name="val-username" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-email">Tanggal Pengeluaran </label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_pengeluaran" id="date-format" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-username">Biaya Untuk</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="biaya_untuk" class="form-control" id="val-username" name="val-username" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="val-username">Jumlah</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah" class="form-control" id="val-username" name="val-username" placeholder="">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-right">
                                        <a href="/LaporanPengeluaran" class="btn btn-secondary">Kembali</a>
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

@endsection