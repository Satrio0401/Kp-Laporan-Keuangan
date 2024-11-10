@extends('Layouts.main')

@section('Content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Retur Pemesanan</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('LaporanReturPemesanan.insertdata') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="no_faktur">Nomor Faktur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select name="no_faktur" class="form-control" id="no_faktur" required>
                                            <option value="">Pilih Nomor Faktur</option>
                                            @foreach($transaksiPenjualan as $item)
                                                <option value="{{ $item->no_faktur }}">{{ $item->no_faktur }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="tanggal_retur">Tanggal Retur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="date" name="tanggal_retur" class="form-control" id="tanggal_retur" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="id_menu">Menu
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <select name="id_menu" class="form-control" id="id_menu" required>
                                            <option value="">Pilih Menu</option>
                                            @foreach($menu as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="jumlah_dikembalikan">Jumlah Dikembalikan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="number" name="jumlah_dikembalikan" class="form-control" id="jumlah_dikembalikan" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="alasan">Alasan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <textarea name="alasan" class="form-control" id="alasan" rows="3" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
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
