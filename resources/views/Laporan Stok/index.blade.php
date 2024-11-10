@extends('Layouts.main')

@section('Content')

<!-- Styles -->
<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('focus-2/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('focus-2/vendor/toastr/css/toastr.min.css') }}">

<form id="laporanForm" action="" method="GET">
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
        <button type="button" id="pdfButton" class="btn btn-square btn-primary" style="margin-right: 10px;">PDF</button>
        <a href="/LaporanStok/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
    </div>
</form>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Laporan Stok Barang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Tersedia</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach($stoks as $stok) <!-- Ganti $stoks dengan $stoks -->
                            <tr>
                                <td scope="row">{{ $no++ }}</td>
                                <td>{{ $stok->kode_barang }}</td>
                                <td>{{ $stok->nama_barang }}</td>
                                <td>{{ $stok->jumlah_tersedia }}</td> <!-- Ganti stok_barang dengan jumlah_tersedia -->
                                <td>
                                    <a href="#" type="button" class="btn btn-warning edit" data-id="{{ $stok->kode_barang }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="#" type="button" class="btn btn-danger delete" data-id="{{ $stok->kode_barang }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('focus-2/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('focus-2/js/quixnav-init.js') }}"></script>
<script src="{{ asset('focus-2/js/custom.min.js') }}"></script>
<script src="{{ asset('focus-2/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('focus-2/js/plugins-init/datatables.init.js') }}"></script>
<script src="{{ asset('focus-2/vendor/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('focus-2/js/plugins-init/toastr-init.js') }}"></script>


<script>
    $(document).ready(function() {
    // Saat tombol PDF diklik, ubah action form untuk menuju ke URL pembuatan PDF
    $('#pdfButton').on('click', function() {
        var form = $('#laporanForm');
        form.attr('action', "{{ route('LaporanStok.cetakpdf') }}"); // Ubah action form ke route PDF
        form.attr('target', '_blank'); // Tambahkan target="_blank" untuk membuka di tab baru
        form.submit(); // Submit form untuk menghasilkan PDF
    });

    let kodeBarang; // Variabel untuk menyimpan kode_barang yang akan dihapus
    let editBarang; // Variabel untuk menyimpan kode_barang yang akan diedit

    $('.delete').on('click', function() {
        kodeBarang = $(this).data('id'); // Ambil kode_barang dari data-id
        $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi
    });

    $('#confirmDelete').on('click', function() {
        // Lakukan penghapusan dengan mengarahkan ke URL yang benar
        window.location.href = "/LaporanStok/delete/" + kodeBarang;
    });

    $('.edit').on('click', function() {
        editBarang = $(this).data('id'); // Ambil kode_barang dari data-id
        $('#editModal').modal('show'); // Menampilkan modal edit
    });

    $('#confirmEdit').on('click', function() {
        // Lakukan pengalihan ke halaman edit dengan kode_barang
        window.location.href = "/LaporanStok/editdata/" + editBarang;
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
