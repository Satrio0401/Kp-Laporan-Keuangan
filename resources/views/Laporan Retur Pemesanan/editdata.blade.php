@extends('Layouts.main')

@section('Content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Edit Retur Pemesanan</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="{{ route('LaporanReturPemesanan.updatedata', $returPemesanan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="no_faktur">Nomor Faktur</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="no_faktur" class="form-control" id="no_faktur" value="{{ $returPemesanan->no_faktur }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_retur">Tanggal Retur</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_retur" class="form-control" id="tanggal_retur" value="{{ $returPemesanan->tanggal_retur }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="id_menu">Menu</label>
                                    <div class="col-lg-10">
                                        <select name="id_menu" class="form-control" required>
                                            @foreach($menus as $menu)
                                                <option value="{{ $menu->id }}" {{ $returPemesanan->id_menu == $menu->id ? 'selected' : '' }}>{{ $menu->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="jumlah_dikembalikan">Jumlah Dikembalikan</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah_dikembalikan" class="form-control" id="jumlah_dikembalikan" value="{{ $returPemesanan->jumlah_dikembalikan }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="alasan">Alasan</label>
                                    <div class="col-lg-10">
                                        <textarea name="alasan" class="form-control" id="alasan" rows="3" required>{{ $returPemesanan->alasan }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <a href="{{ route('LaporanReturPemesanan.index') }}" class="btn btn-secondary">Kembali</a>
                                        <button type="submit" class="btn btn-primary">Update Transaksi</button>
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
