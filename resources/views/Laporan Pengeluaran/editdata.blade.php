@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Data Pengeluaran</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanPengeluaran/updatedata/{{ $Pengeluarans->kode_biaya }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kode_biaya">Kode Biaya
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="kode_biaya" class="form-control" id="kode_biaya" value="{{ $Pengeluarans->kode_biaya }}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_pengeluaran">Tanggal Pengeluaran 
                                        <span class="text-danger">*</span> 
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_pengeluaran" id="tanggal_pengeluaran" class="form-control" value="{{ $Pengeluarans->tanggal_pengeluaran }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="biaya_untuk">Biaya Untuk
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="biaya_untuk" class="form-control" id="biaya_untuk" value="{{ $Pengeluarans->biaya_untuk }}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="jumlah">Jumlah
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="total_pengeluaran" class="form-control" id="total_pengeluaran" value="{{ $Pengeluarans->total_pengeluaran }}" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <a href="/LaporanPengeluaran" class="btn btn-secondary">Kembali</a>
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
