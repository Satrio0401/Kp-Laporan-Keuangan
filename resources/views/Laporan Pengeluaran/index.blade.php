@extends('Layouts.main')

@section('Content')

<!-- Styles -->
<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('focus-2/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('focus-2/vendor/toastr/css/toastr.min.css') }}">


<form id="laporanForm" action="{{ route('LaporanPengeluaran.search') }}" method="GET">
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
        <input type="date" name="start_date" id="start_date" class="form-control" style="width: auto; margin-right: 10px;" placeholder="Start Date">
        <input type="date" name="end_date" id="end_date" class="form-control" style="width: auto; margin-right: 10px;" placeholder="End Date">
        <button type="submit" class="btn btn-square btn-primary" style="margin-right: 10px;">Search</button>
        <button type="button" id="pdfButton" class="btn btn-square btn-primary" style="margin-right: 10px;">PDF</button>
        <a href="/LaporanPengeluaran/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
    </div>
</form>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Laporan Pengeluaran</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Biaya</th>
                                <th>Tanggal Pengeluaran</th>
                                <th>Biaya Untuk</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($Pengeluarans as $Pengeluaran)
                                <tr>
                                    <td scope="laporankeuangan">{{ $no++ }}</td>
                                    <td>{{ $Pengeluaran->kode_biaya }}</td>
                                    <td>{{ $Pengeluaran->tanggal_pengeluaran }}</td>
                                    <td>{{ $Pengeluaran->biaya_untuk }}</td>
                                    <td>{{ formatRupiah($Pengeluaran->total_pengeluaran) }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning" data-id="{{ $Pengeluaran->kode_biaya }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger delete" data-id="{{ $Pengeluaran->kode_biaya }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th><strong>TOTAL</strong></th>
                                    <td><strong>{{ formatRupiah($Pengeluarans->sum('total_pengeluaran')) }}</strong></td> <!-- Jumlah total_pengeluaran -->
                                    <td></td>
                                </tr>
                            </tfoot>
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
        form.attr('action', "{{ route('LaporanPengeluaran.cetakpdf') }}"); // Ubah action form ke route PDF
        form.attr('target', '_blank'); // Tambahkan target="_blank" untuk membuka di tab baru
        form.submit(); // Submit form untuk menghasilkan PDF
    });
        let kodeBiaya; // Variabel untuk menyimpan kode_biaya yang akan dihapus
        let editBiaya; // Variabel untuk menyimpan kode_biaya yang akan diedit

        // Event delegation untuk tombol delete
        $(document).on('click', '.delete', function() {
            kodeBiaya = $(this).data('id'); // Ambil kode_biaya dari data-id
            $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi
        });

        $('#confirmDelete').on('click', function() {
            window.location.href = "/LaporanPengeluaran/delete/" + kodeBiaya; // Ganti no_faktur dengan kode_biaya
        });

        // Event delegation untuk tombol edit
        $(document).on('click', '.btn-warning', function() {
            editBiaya = $(this).data('id'); // Ambil kode_biaya dari data-id
            $('#editModal').modal('show');
        });

        $('#confirmEdit').on('click', function() {
            window.location.href = "/LaporanPengeluaran/editdata/" + editBiaya; // Ganti no_faktur dengan kode_biaya
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
