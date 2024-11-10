@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Retur Pembelian</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanReturPembelian/updatedata/{{ $returPembelian->no_faktur }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12"> <!-- Use the full width for the form -->
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="no_faktur">Nomor Faktur</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="no_faktur" class="form-control" id="no_faktur" value="{{ $returPembelian->no_faktur }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_retur">Tanggal Retur</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_retur" id="tanggal_retur" class="form-control" value="{{ $returPembelian->tanggal_retur }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kode_supplier">Kode Supplier</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="kode_supplier" class="form-control" id="kode_supplier" value="{{ $returPembelian->kode_supplier }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_supplier">Nama Supplier</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama" class="form-control" id="nama" value="{{ $returPembelian->supplier->nama }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_barang">Nama Barang</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="{{ $returPembelian->nama_barang }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="jumlah_dikembalikan">Jumlah Dikembalikan</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah_dikembalikan" class="form-control" id="jumlah_dikembalikan" value="{{ $returPembelian->jumlah_dikembalikan }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="alasan">Alasan</label>
                                    <div class="col-lg-10">
                                        <textarea name="alasan" class="form-control" id="alasan" placeholder="Masukkan alasan" required>{{ $returPembelian->alasan }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="/LaporanReturPembelian" class="btn btn-secondary">Back</a> <!-- Back button -->
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
