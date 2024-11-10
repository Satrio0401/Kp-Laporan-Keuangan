@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Data Pembelian</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form class="form-valide" action="/LaporanPembelian/tambahdata/insertdata" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12"> <!-- Adjusted to take the full width -->
                                <div class="form-group row">
                                    <label for="no_faktur" class="col-lg-2 col-form-label">Nomor Faktur</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="no_faktur" class="form-control" id="no_faktur" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tanggal_pembelian" class="col-lg-2 col-form-label">Tanggal Pembelian</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="kode_supplier" class="col-lg-2 col-form-label">Supplier</label>
                                    <div class="col-lg-10">
                                        <select name="kode_supplier" class="form-control" id="kode_supplier" required>
                                            <option value="">Pilih Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->kode_supplier }}">{{ $supplier->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_barang" class="col-lg-2 col-form-label">Nama Barang</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="harga_satuan" class="col-lg-2 col-form-label">Harga Satuan</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="harga_satuan" class="form-control" id="harga_satuan"  oninput="calculateTotal()" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="jumlah" class="col-lg-2 col-form-label">Jumlah</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="jumlah" class="form-control" id="jumlah"  oninput="calculateTotal()" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Satuan" class="col-lg-2 col-form-label">Satuan</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="Satuan" class="form-control" id="Satuan" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="total_harga" class="col-lg-2 col-form-label">Total Harga</label>
                                    <div class="col-lg-10">
                                        <input type="number" name="total_harga" class="form-control" id="total_harga" required >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-10 offset-lg-2 text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="/LaporanPembelian" class="btn btn-secondary">Back</a> <!-- Back button -->
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
