@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Data Pembelian</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanPembelian/updatedata/{{ $pembelian->no_faktur }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="no_faktur">Nomor Faktur
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="no_faktur" class="form-control" id="no_faktur" value="{{ $pembelian->no_faktur }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_pembelian">Tanggal Pembelian
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control" value="{{ $pembelian->tanggal_pembelian }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="kode_supplier">Supplier
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <select name="kode_supplier" class="form-control" id="kode_supplier" required>
                                            <option value="">Pilih Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->kode_supplier }}" {{ $supplier->kode_supplier == $pembelian->kode_supplier ? 'selected' : '' }}>
                                                    {{ $supplier->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_barang">Nama Barang
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="{{ $pembelian->nama_barang }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="harga_satuan">Harga Satuan
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="harga_satuan" class="form-control" id="harga_satuan" value="{{ $pembelian->harga_satuan }}" required oninput="calculateTotal()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="jumlah">Jumlah
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah" class="form-control" id="jumlah" value="{{ $pembelian->jumlah }}" required oninput="calculateTotal()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="Satuan">Satuan
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="Satuan" class="form-control" id="Satuan" value="{{ $pembelian->Satuan }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="total_harga">Total Harga
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="total_harga" class="form-control" id="total_harga" value="{{ $pembelian->total_harga }}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <a href="/LaporanPembelian" class="btn btn-secondary">Kembali</a>
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

<script>
    function calculateTotal() {
        const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
        const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
        const totalHarga = hargaSatuan * jumlah;
        document.getElementById('total_harga').value = totalHarga.toFixed(2);
    }
</script>

@endsection
