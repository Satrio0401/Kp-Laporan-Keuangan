@extends('Layouts.main')

@section('Content')

<link href="{{ asset('focus-2/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Basic Datatable</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <a href="/tambahdata" class="btn btn-square btn-primary">Add Data</a>
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Invoice Number</th>
                                                <th>Purchase Date</th>
                                                <th>Supplier Name</th>
                                                <th>Total Invoice</th>
                                                <th>Paid Payment</th>
                                                <th>Due Payment</th>
                                                <th>Supplier ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                           $no = 1;
                                        @endphp
                                        @foreach($pembelians as $pembelian)
                                            <tr>
                                                <td scope="pembelian">{{$no++}}</td>
                                                <td>{{ $pembelian->invoice_number }}</td>
                                                <td>{{ $pembelian->purchase_date }}</td>
                                                <td>{{ $pembelian->supplier_name }}</td>
                                                <td>{{ $pembelian->total_invoice }}</td>
                                                <td>{{ $pembelian->amount_paid }}</td>
                                                <td>{{ $pembelian->due_amount }}</td>
                                                <td></td>
                                                <td>
                                                   <a href="/editdata/{{$pembelian->id}}" type="button" class="btn btn-rounded btn-warning">Edit</a>
                                                   <a href="/delete/{{$pembelian->id}}" type="button" class="btn btn-rounded btn-danger">Delete</a>
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

<script src="{{ asset('focus-2/vendor/global/global.min.js')}}"></script>
<script src="{{ asset('focus-2/js/quixnav-init.js')}}"></script>
<script src="{{ asset('focus-2/js/custom.min.js')}}"></script>

<script src="{{ asset('focus-2/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('focus-2/js/plugins-init/datatables.init.js')}}"></script>


@endsection