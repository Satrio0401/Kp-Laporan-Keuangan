@extends('Layouts.main')

@section('Content')

<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

<form id="laporanForm" action="{{ route('LaporanReturPembelian.search') }}" method="GET">
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
        <input type="date" name="start_date" class="form-control" style="width: auto; margin-right: 10px;" placeholder="Start Date">
        <input type="date" name="end_date" class="form-control" style="width: auto; margin-right: 10px;" placeholder="End Date">
        <button type="submit" class="btn btn-square btn-primary" style="margin-right: 10px;">Search</button>
        <button type="button" id="pdfButton" class="btn btn-square btn-primary" style="margin-right: 10px;">PDF</button>
        <a href="/LaporanReturPembelian/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
    </div>
</form>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Laporan Retur Pembelian</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Faktur</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Nama Supplier</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Total Faktur</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                           $no = 1;
                           $totalJumlah = 0;
                        @endphp
                        @foreach($returPembelian as $item)
                            <tr>
                                <td scope="laporankeuangan">{{ $no++ }}</td>
                                <td>{{ $item->no_faktur }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_retur)->format('d/m/Y') }}</td>
                                <td>{{ $item->supplier->nama ?? '-' }}</td>
                                <td>{{ $item->pembelian->nama_barang ?? 'N/A' }}</td>
                                <td>{{ $item->jumlah_dikembalikan }} {{$item->pembelian->Satuan}}</td>
                                <td>
                                    @if($item->status == 'diterima')
                                        {{ formatRupiah($item->jumlah_dikembalikan * $item->pembelian->harga_satuan) }}
                                    @else
                                        Rp 0
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('LaporanReturPembelian.updateStatus', $item->no_faktur) }}" method="POST" class="status-form">
                                        @csrf
                                        <div class="dropdown">
                                            <button class="btn {{ $item->status == 'diterima' ? 'btn-success' : ($item->status == 'ditolak' ? 'btn-danger' : 'btn-primary') }} "
                                                    type="button" id="dropdownMenuButton{{ $item->no_faktur}}" 
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ucfirst($item->status)}}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->no_faktur}}">
                                                <button type="submit" class="dropdown-item" name="status" value="diterima" {{ $item->status != 'pending' ? 'disabled' : '' }}>Diterima</button>
                                                <button type="submit" class="dropdown-item" name="status" value="ditolak" {{ $item->status != 'pending' ? 'disabled' : '' }}>Ditolak</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning edit" data-id="{{ $item->no_faktur }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" class="btn btn-danger delete" data-id="{{ $item->no_faktur }}"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @php
                            // Hitung total untuk footer
                            if($item->status == 'diterima') {
                                $totalJumlah += $item->jumlah_dikembalikan * $item->pembelian->harga_satuan;
                            }
                            @endphp
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-end"><strong>TOTAL</strong></td>
                                <td><strong>{{ formatRupiah($totalJumlah) }}</strong></td> <!-- Total subtotal -->
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('focus-2/vendor/global/global.min.js')}}"></script>
<script src="{{ asset('focus-2/js/quixnav-init.js')}}"></script>
<script src="{{ asset('focus-2/js/custom.min.js')}}"></script>

<script src="{{ asset('focus-2/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('focus-2/js/plugins-init/datatables.init.js')}}"></script>

<!-- Link ke Toastr CSS -->
<link href="{{ asset('focus-2/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
<script src="{{ asset('focus-2/vendor/toastr/js/toastr.min.js')}}"></script>
<script src="{{ asset('focus-2/js/plugins-init/toastr-init.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    $(document).ready(function() {
    // Saat tombol PDF diklik, ubah action form untuk menuju ke URL pembuatan PDF
    $('#pdfButton').on('click', function() {
        var form = $('#laporanForm');
        form.attr('action', "{{ route('LaporanReturPembelian.cetakpdf') }}"); // Ubah action form ke route PDF
        form.attr('target', '_blank'); // Tambahkan target="_blank" untuk membuka di tab baru
        form.submit(); // Submit form untuk menghasilkan PDF
    });

    let noFaktur; // Variabel untuk menyimpan no_faktur yang akan dihapus
    let editFaktur; // Variabel untuk menyimpan no_faktur yang akan diedit

    $('.delete').on('click', function() {
        noFaktur = $(this).data('id'); // Ambil no_faktur dari data-id
        $('#deleteModal').modal('show'); // Tampilkan modal konfirmasi
    });

    $('#confirmDelete').on('click', function() {
        // Lakukan penghapusan dengan mengarahkan ke URL yang benar
        window.location.href = "/LaporanReturPembelian/delete/" + noFaktur;
    });

    $('.edit').on('click', function() {
        editFaktur = $(this).data('id'); // Ambil no_faktur dari data-id
        $('#editModal').modal('show'); // Menampilkan modal edit
    });

    $('#confirmEdit').on('click', function() {
        // Lakukan pengalihan ke halaman edit dengan no_faktur
        window.location.href = "/LaporanReturPembelian/editdata/" + editFaktur;
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
