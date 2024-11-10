@extends('Layouts.main')

@section('Content')

<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

<div style="text-align: right; margin-bottom: 20px;">
    <a href="" class="btn btn-square btn-primary">PDF</a>
    <a href="/DaftarMenu/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Menu</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                           $no = 1;
                        @endphp
                        @foreach($menu as $item)
                            <tr>
                                <td scope="menu">{{$no++}}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ formatRupiah($item->harga)}}</td>
                                <td>
                                    <a href="#" type="button" class="btn btn-warning" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="#" type="button" class="btn btn-danger delete" data-id="{{$item->id}}"><i class="fa-solid fa-trash"></i></a>
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

<script src="{{ asset('focus-2/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('focus-2/js/quixnav-init.js') }}"></script>
<script src="{{ asset('focus-2/js/custom.min.js') }}"></script>
<script src="{{ asset('focus-2/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('focus-2/js/plugins-init/datatables.init.js') }}"></script>
<script src="{{ asset('focus-2/vendor/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('focus-2/js/plugins-init/toastr-init.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        // Saat tombol PDF diklik, ubah action form untuk menuju ke URL pembuatan PDF
        $('#pdfButton').on('click', function() {
            var form = $('#laporanForm');
            form.attr('action', "{{ route('laporanpembelian.cetakpdf') }}"); // Ubah action form ke route PDF
            form.submit(); // Submit form untuk menghasilkan PDF
        });

        let idMenu; // Variabel untuk menyimpan no_faktur yang akan dihapus
        let editMenu; // Variabel untuk menyimpan no_faktur yang akan diedit

        // Event delegation untuk tombol delete
        $(document).on('click', '.delete', function() {
            idMenu = $(this).data('id'); // Ambil no_faktur dari data-id
            $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi
        });

        $('#confirmDelete').on('click', function() {
            window.location.href = "/DaftarMenu/delete/" + idMenu;
        });

        // Event delegation untuk tombol edit
        $(document).on('click', '.btn-warning', function() {
            editMenu = $(this).data('id'); // Ambil no_faktur dari data-id
            $('#editModal').modal('show');
        });

        $('#confirmEdit').on('click', function() {
            window.location.href = "/DaftarMenu/editdata/" + editMenu;
        });

        // Toastr untuk notifikasi sukses
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

        // Toastr untuk notifikasi error
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
