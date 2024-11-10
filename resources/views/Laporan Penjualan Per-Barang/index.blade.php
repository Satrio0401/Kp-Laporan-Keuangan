@extends('Layouts.main')

@section('Content')

<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

{{-- <div style="text-align: right; margin-bottom: 20px;">
    <a href="" class="btn btn-square btn-primary">PDF</a>
    <a href="" class="btn btn-square btn-primary">Excel</a>
    <a href="/LaporanPenjualanPerBarang/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
</div> --}}

<form id="laporanForm" action="{{ route('LaporanPenjualanPerBarang.search') }}" method="GET">
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
            <input type="date" name="start_date" class="form-control" style="width: auto; margin-right: 10px;" placeholder="Start Date">
            <input type="date" name="end_date" class="form-control" style="width: auto; margin-right: 10px;" placeholder="End Date">
            <button type="submit" class="btn btn-square btn-primary" style="margin-right: 10px;">Search</button>
            <button type="button" id="pdfButton" class="btn btn-square btn-primary" style="margin-right: 10px;">PDF</button>
            <a href="/LaporanPenjualanPerBarang/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
    </div>
</form>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Laporan Penjualan Per-Barang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Faktur</th>
                                <th>tanggal Pemesanan</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                           $no = 1;
                           $totalJumlah = 0; // Total jumlah
                           $totalSubtotal = 0; // Total subtotal
                        @endphp
                       @foreach($penjualanPerBarang as $item)
                       <tr>
                           <td>{{$no++}}</td>
                           <td>{{ $item->transaksiPenjualan->no_faktur }}</td>
                           <td>{{ $item->transaksiPenjualan->tanggal_pemesanan }}</td>
                           <td>{{ $item->menu ? $item->menu->nama : 'N/A' }}</td> <!-- Memeriksa null -->
                           <td>{{ $item->jumlah }}</td>
                           <td>{{ formatRupiah($item->subtotal) }}</td>
                           <td>
                            <a href="#" class="btn btn-warning edit" data-id="{{$item->no_faktur}}"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button type="button" class="btn btn-danger delete" data-id="{{$item->no_faktur}}" data-toggle="modal" data-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                           </td>
                       </tr>
                       @php
                          // Hitung total
                          $totalJumlah += $item->jumlah; 
                          $totalSubtotal += $item->subtotal; 
                       @endphp
                   @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>TOTAL</strong></td>
                                <td><strong>{{ $totalJumlah }}</strong></td> <!-- Total jumlah barang -->
                                <td><strong>{{ formatRupiah($totalSubtotal) }}</strong></td> <!-- Total subtotal -->
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

!-- Modal Konfirmasi Edit -->
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

<script src="{{ asset('focus-2/vendor/global/global.min.js')}}"></script>
<script src="{{ asset('focus-2/js/quixnav-init.js')}}"></script>
<script src="{{ asset('focus-2/js/custom.min.js')}}"></script>

<script src="{{ asset('focus-2/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('focus-2/js/plugins-init/datatables.init.js')}}"></script>

<script src="{{ asset('focus-2/vendor/toastr/js/toastr.min.js')}}"></script>
<script src="{{ asset('focus-2/js/plugins-init/toastr-init.js')}}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        // Saat tombol PDF diklik, ubah action form untuk menuju ke URL pembuatan PDF
        $('#pdfButton').on('click', function() {
            var form = $('#laporanForm');
            form.attr('action', "{{ route('LaporanPenjualanPerBarang.cetakpdf') }}"); // Ubah action form ke route PDF
            form.attr('target', '_blank'); 
            form.submit(); // Submit form untuk menghasilkan PDF
        });

        let noFaktur; // Variabel untuk menyimpan no_faktur yang akan dihapus
        let editFaktur; // Variabel untuk menyimpan no_faktur yang akan diedit

        // Event delegation untuk tombol delete
        $(document).on('click', '.delete', function() {
            noFaktur = $(this).data('id'); // Ambil no_faktur dari data-id
            $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi
        });

        $('#confirmDelete').on('click', function() {
            window.location.href = "/LaporanPenjualanPerBarang/delete/" + noFaktur;
        });

        // Event delegation untuk tombol edit
        $(document).on('click', '.edit', function() {
            editFaktur = $(this).data('id'); // Ambil no_faktur dari data-id
            $('#editModal').modal('show');
        });

        $('#confirmEdit').on('click', function() {
            window.location.href = "/LaporanPenjualanPerBarang/editdata/" + editFaktur;
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