@extends('Layouts.main')

@section('Content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Data Transaksi dan Barang</h4>
                </div>
                <div class="card-body">
                    <div class="form-validation">
                        <form class="form-valide" action="/LaporanTransaksiPenjualan/tambahdata/insertdata" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Data Transaksi Utama -->
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" for="no_faktur">No Faktur
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="text" id="no_faktur" name="no_faktur" class="form-control" reaadonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" for="tanggal_pemesanan">Tanggal Pemesanan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" for="nama_pelanggan">Nama Pelanggan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-form-label" for="total_harga">Total Harga
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-10">
                                            <input type="number" id="total_harga" name="total_harga" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div id="items-container"></div>
    
                                    
                                    <!-- Button Kembali dan Simpan di Pojok Kanan Bawah -->
                                    <div class="row mt-4">
                                        <div class="col-lg-12 text-right">
                                            <button type="button" class="btn btn-danger" id="add-item" onclick="addItem()">Tambah Item</button>
                                            <a href="/LaporanTransaksiPenjualan" class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updatePrice(select) {
        const price = select.options[select.selectedIndex].getAttribute('data-price');
        const itemDiv = select.closest('.item');
        itemDiv.querySelector('.price').value = price ? price : 0;
        calculateSubtotal(itemDiv.querySelector('.quantity'));
    }

    function addItem() {
        const itemsContainer = document.getElementById('items-container');
        const newItem = document.createElement('div');
        newItem.classList.add('item', 'mb-3');
        newItem.innerHTML = `
            <div class="form-group row">
                <label class="col-lg-2 col-form-label" for="menu_id">Pilih Menu
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-10">
                    <select class="form-control menu_id" name="menu_id[]" required onchange="updatePrice(this)">
                        <option value="" disabled selected>Pilih Menu Terlebih Dahulu</option>
                        @foreach($menu as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->harga }}">
                                {{ $item->nama }} - Rp {{ number_format($item->harga, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label" for="jumlah">Jumlah
                    <span class="text-danger">*</span>
                </label>
                <div class="col-lg-10">
                    <input type="number" class="form-control quantity" name="jumlah[]" required min="1" value="1" oninput="calculateSubtotal(this)">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label" for="harga_per_item">Harga per Item</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control price" name="harga_per_item[]" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-2 col-form-label" for="subtotal">Subtotal</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control subtotal" name="subtotal[]" readonly>
                </div>
            </div>
        `;
        itemsContainer.appendChild(newItem);
        updatePrice(newItem.querySelector('.menu_id'));
    }

    function calculateSubtotal(input) {
        const itemDiv = input.closest('.item');
        const quantity = parseFloat(input.value) || 0;
        const price = parseFloat(itemDiv.querySelector('.price').value) || 0;
        const subtotal = quantity * price;
        itemDiv.querySelector('.subtotal').value = subtotal.toFixed(2);
        updateTotalPrice();
    }

    function updateTotalPrice() {
        const subtotalElements = document.querySelectorAll('.subtotal');
        let total = 0;
        subtotalElements.forEach((subtotal) => {
            total += parseFloat(subtotal.value) || 0;
        });
        document.getElementById('total_harga').value = total.toFixed(2);
    }

    // ✅ Tambahan untuk generate no faktur otomatis
    $('#tanggal_pemesanan').on('change', function () {
        var tanggal = $(this).val();

        if (tanggal) {
            $.ajax({
                url: '/generate-no-faktur',
                type: 'GET',
                data: { tanggal_pemesanan: tanggal },
                success: function (data) {
                    $('#no_faktur').val(data.no_faktur);
                }
            });
        }
    });
</script>


@endsection
