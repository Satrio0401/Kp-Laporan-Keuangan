@extends('Layouts.main')

@section('Content')
    <link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <form id="laporanForm" action="{{ route('LaporanTransaksiPenjualan.search') }}" method="GET">
        <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
            <input type="date" name="start_date" id="start_date" class="form-control"
                style="width: auto; margin-right: 10px;" placeholder="Start Date">
            <input type="date" name="end_date" id="end_date" class="form-control"
                style="width: auto; margin-right: 10px;" placeholder="End Date">
            <button type="submit" class="btn btn-square btn-primary" style="margin-right: 10px;">Search</button>
            <button type="button" id="pdfButton" class="btn btn-square btn-primary"
                style="margin-right: 10px;">PDF</button>
            <a href="/LaporanTransaksiPenjualan/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
        </div>
    </form>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Transaksi Penjualan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Faktur</th>
                                    <th>Tanggal Pemesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $totalJumlah = 0; // Total jumlah
                                @endphp
                                @foreach ($transaksiPenjualan as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->no_faktur }}</td>
                                        <td>{{ $item->tanggal_pemesanan }}</td>
                                        <td>{{ $item->nama_pelanggan }}</td>
                                        <td>{{ formatRupiah($item->total_harga) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info detail-btn"
                                                data-id="{{ $item->no_faktur }}">Detail</button>
                                            <a href="#" class="btn btn-warning edit"
                                                data-id="{{ $item->no_faktur }}"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <button type="button" class="btn btn-danger delete"
                                                data-id="{{ $item->no_faktur }}" data-toggle="modal"
                                                data-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @php
                                        // Hitung total
                                        $totalJumlah += $item->total_harga;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>TOTAL</strong></td>
                                    <td><strong>{{ formatRupiah($totalJumlah) }}</strong></td> <!-- Total subtotal -->
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nomor Faktur:</strong> <span id="modalFaktur"></span></p>
                    <p><strong>Tanggal Pemesanan:</strong> <span id="modalTanggal"></span></p>
                    <p><strong>Nama Pelanggan:</strong> <span id="modalPelanggan"></span></p>
                    <p><strong>Total Harga:</strong> <span id="modalTotal"></span></p>
                    <h5>Detail Pesanan:</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modalItems"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Konfirmasi Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin mengedit data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('focus-2/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('focus-2/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('focus-2/js/custom.min.js') }}"></script>
    <script src="{{ asset('focus-2/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('focus-2/js/plugins-init/datatables.init.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            // Saat tombol PDF diklik, ubah action form untuk menuju ke URL pembuatan PDF
            $('#pdfButton').on('click', function() {
                var form = $('#laporanForm');
                form.attr('action',
                "{{ route('LaporanTransaksiPenjualan.cetakpdf') }}"); // Ubah action form ke route PDF
                form.attr('target', '_blank'); // Tambahkan target="_blank" untuk membuka di tab baru
                form.submit(); // Submit form untuk menghasilkan PDF
            });

            $(document).on('click', '.detail-btn', function() {
                var noFaktur = $(this).data('id');
                console.log("No Faktur yang diklik:", noFaktur);

                $('#modalItems').empty(); // Kosongkan list item pesanan sebelumnya

                // Ambil data transaksi
                @foreach ($transaksiPenjualan as $transaksi)
                    if (noFaktur == "{{ $transaksi->no_faktur }}") {
                        console.log("Transaksi Ditemukan:", "{{ $transaksi->no_faktur }}");

                        $('#modalFaktur').text(noFaktur);
                        $('#modalTanggal').text("{{ $transaksi->tanggal_pemesanan }}");
                        $('#modalPelanggan').text("{{ $transaksi->nama_pelanggan }}");
                        $('#modalTotal').text("{{ formatRupiah($transaksi->total_harga) }}");

                        // Debug: Cek penjualan per barang
                        var penjualanPerBarang = @json($transaksi->penjualanPerBarang);
                        console.log("Data Penjualan Per Barang:", penjualanPerBarang);

                        if (penjualanPerBarang.length > 0) {
                            penjualanPerBarang.forEach(item => {
                                console.log("Item:", item); // Debug: Cek setiap item
                                var listItem = '<tr>' +
                                    '<td>' + (item.menu ? item.menu.nama : 'Tidak tersedia') +
                                    '</td>' +
                                    '<td>' + item.jumlah + '</td>' +
                                    '<td>' + item.harga + '</td>' +
                                    '<td>' + item.subtotal + '</td>' +
                                    '</tr>';
                                $('#modalItems').append(listItem);
                            });
                        } else {
                            $('#modalItems').append('<tr><td colspan="4">Tidak ada data</td></tr>');
                        }
                    }
                @endforeach

                // Show modal
                $('#detailModal').modal('show');
            });


            $('.delete').on('click', function() {
                noFaktur = $(this).data('id'); // Ambil no_faktur dari data-id
                $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi
            });

            $('#confirmDelete').on('click', function() {
                // Lakukan penghapusan dengan mengarahkan ke URL yang benar
                window.location.href = "/LaporanTransaksiPenjualan/delete/" + noFaktur;
            });

            // $('.btn-warning').on('click', function() {
            //     editFaktur = $(this).data('id'); // Ambil no_faktur dari data-id
            //     $('#editModal').modal('show'); // Tampilkan modal konfirmasi
            // });

            $(document).on('click', '.btn-warning', function() {
    editFaktur = $(this).data('id'); 
    console.log("No Faktur yang akan diedit:", editFaktur);
    $('#editModal').modal('show'); 
});

            $('#confirmEdit').on('click', function() {
                // Lakukan pengalihan ke halaman edit dengan no_faktur
                window.location.href = "/LaporanTransaksiPenjualan/editdata/" + editFaktur;
            });

            @if (Session::has('success'))
                toastr.info("{{ Session::get('success') }}", {
                    positionClass: "toast-top-right",
                    timeOut: 5000,
                    closeButton: true,
                    debug: false,
                    newestOnTop: true,
                    progressBar: true,
                    preventDuplicates: true,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: false
                });
            @endif

            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}", {
                    positionClass: "toast-top-right",
                    timeOut: 5000,
                    closeButton: true,
                    debug: false,
                    newestOnTop: true,
                    progressBar: true,
                    preventDuplicates: true,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: false
                });
            @endif

        });
    </script>
@endsection
