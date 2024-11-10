@extends('Layouts.main')

@section('Content')

<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

<div style="text-align: right; margin-bottom: 20px;">
    <a href="" class="btn btn-square btn-primary">PDF</a>
    <a href="" class="btn btn-square btn-primary">Excel</a>
    <a href="/DaftarPengguna/tambahdata" class="btn btn-square btn-primary">Tambah Data</a>
</div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Pengguna</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                           $no = 1;
                                        @endphp
                                        @foreach($users as $user)
                                            <tr>
                                                <td scope="pembelian">{{$no++}}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->password }}</td>
                                                <td>{{ $user->create_at }}</td>
                                                <td>
                                                    <a href="/DaftarPengguna/editdata/{{$user->id}}" type="button" class="btn btn-rounded btn-warning" ><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="#" type="button" class="btn btn-danger delete" data-id="{{$user->id }}"><i class="fa-solid fa-trash"></i></a>
                                                 </td>
                                            </tr>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
    $('.delete').click (function(){
        var userid = $(this).attr('data-id')
        swal({
            title: "Apakah Kamu Yakin ?",
            text: "Once deleted, you will not be able to recover this imaginary file"
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
    .then((willDelete) => {
        if (willDelete) {
            window.location = "/DaftarPengguna/delete/"+userid+" "
           swal("Poof! Your imaginary file has been deleted!", {
           icon: "success",
        });
        } else {
    swal("Your imaginary file is safe!");
        }
      });

    });

</script>

<script>
    @if (Session::has('success'))
    toastr.info("{{ Session::get('success') }}"), {
                    positionClass: "toast-top-right",
                    timeOut: 5e3,
                    closeButton: !0,
                    debug: !1,
                    newestOnTop: !0,
                    progressBar: !0,
                    preventDuplicates: !0,
                    onclick: null,
                    showDuration: "300",
                    hideDuration: "1000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    tapToDismiss: !1
                }
    @endif


</script>


@endsection