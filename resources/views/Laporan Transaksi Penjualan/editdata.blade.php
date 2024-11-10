@extends('Layouts.main')

@section('Content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Edit Data Transaksi dan Barang</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{ url('/LaporanTransaksiPenjualan/updatedata/' . $transaksiPenjualan->no_faktur) }}" method="POST">
                        @csrf
                        <input type="hidden" name="no_faktur" value="{{ $transaksiPenjualan->no_faktur }}">
                        <div class="row">
                            <!-- Data Transaksi Utama -->
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="no_faktur">No Faktur
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" id="no_faktur" name="no_faktur" class="form-control" value="{{ $transaksiPenjualan->no_faktur }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="tanggal_pemesanan">Tanggal Pemesanan
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" class="form-control" value="{{ $transaksiPenjualan->tanggal_pemesanan }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="nama_pelanggan">Nama Pelanggan
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="{{ $transaksiPenjualan->nama_pelanggan }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="total_harga">Total Harga
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" id="total_harga" name="total_harga" class="form-control" readonly value="{{ $transaksiPenjualan->total_harga }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Data Barang -->
                            <div class="col-lg-12 mt-4">
                                <h5>Data Barang</h5>
                                <div id="items-container">
                                    @foreach($transaksiPenjualan->penjualanPerBarang as $item)
                                        <div class="item col-xl-12 mb-3" data-item-id="{{ $item->id }}">
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="menu_id">Menu
                                                </label>
                                                <div class="col-lg-10">
                                                    <select class="form-control menu_id" name="menu_id[]" required onchange="updatePrice(this)">
                                                        <option value="" disabled>Pilih Menu Terlebih Dahulu</option>
                                                        @foreach($menu as $menuItem)
                                                            <option value="{{ $menuItem->id }}" data-price="{{ $menuItem->harga }}" {{ $menuItem->id == $item->id_menu ? 'selected' : '' }}>
                                                                {{ $menuItem->nama }} - Rp {{ number_format($menuItem->harga, 2, ',', '.') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="jumlah">Jumlah
                                                </label>
                                                <div class="col-lg-10">
                                                    <input type="number" class="form-control quantity" name="jumlah[]" required min="1" value="{{ $item->jumlah }}" oninput="calculateSubtotal(this)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="harga_per_item">Harga per Item</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control price" name="harga_per_item[]" readonly value="{{ $item->harga }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="subtotal">Subtotal</label>
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control subtotal" name="subtotal[]" readonly value="{{ $item->subtotal }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group row">
                                        <div class="col-lg-10 offset-lg-2 text-right">
                                            <a href="/LaporanTransaksiPenjualan" class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
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
    // Function to update price and subtotal for the selected item without adding new items
    function updatePrice(select) {
        const price = select.options[select.selectedIndex].getAttribute('data-price');
        const itemDiv = select.closest('.item');
        itemDiv.querySelector('.price').value = price;
        calculateSubtotal(itemDiv.querySelector('.quantity'));
    }

    // Calculate subtotal for an item based on its quantity and price
    function calculateSubtotal(input) {
        const itemDiv = input.closest('.item');
        const quantity = input.value;
        const price = parseFloat(itemDiv.querySelector('.price').value) || 0;
        const subtotal = quantity * price;
        itemDiv.querySelector('.subtotal').value = subtotal.toFixed(2);
        updateTotalPrice();
    }

    // Calculate and update total price based on all subtotals
    function updateTotalPrice() {
        const subtotalElements = document.querySelectorAll('.subtotal');
        let total = 0;
        subtotalElements.forEach((subtotal) => {
            total += parseFloat(subtotal.value) || 0;
        });
        document.getElementById('total_harga').value = total.toFixed(2);
    }
</script>

@endsection
