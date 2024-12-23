@extends('backend.layouts.master')
@section('title','Faniha | Products')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-muted">Orders</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('process-all') }}" method="POST" id="form-process-all">
                @csrf
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mb-3">
                    Proses
            </button>

            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="product-dataTable">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Customer Name</td>
                            <td>Phone</td>
                            <td>Address</td>
                            <td>Total Price</td>
                            <td>Payment Method</td>
                            <td>Payment Status</td>
                            <td>Status</td>
                            <td>Action</td>
                            <td><input type="checkbox" id="select-all"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ Str::limit(Str::words($order->address, 10, '...'), 20, '...') }}</td>
                            <td>{{ 'Rp. ' . number_format($order->total_amount, 0, ',' , '.') }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td><div class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-danger' }} text-white pill">{{ $order->payment_status }}</div></td>
                            <td>
                                @php
                                    if($order->order_status === 'new'){
                                        $classStatus =  'bg-success';
                                    } else if($order->order_status === 'process'){
                                        $classStatus = 'bg-warning';
                                    } else if($order->order_status === 'delivered'){
                                        $classStatus = 'bg-primary';
                                    } else if($order->order_status === 'cancel'){
                                        $classStatus = 'bg-danger';
                                    } else {
                                        $classStatus = 'bg-secondary';
                                    }
                                @endphp
                                <div class="badge {{ $classStatus }} text-white pill" >{{ $order->order_status }}</div>
                            </td>
                            <td><a href="{{ route('order-detail', ['order_number' => $order->order_number]) }}" class="btn btn-primary btn-sm" style="height:30px; width:30px;border-radius:50%" ><i class="fas fa-eye"></i></a></td>
                            <td><input type="checkbox"  name="selected_orders[]" value="{{ $order->order_number }}"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <span style="float:right">{{$orders->links()}}</span>
            </div>
        </form>
        </div>
    </div>

<!-- End Modal View -->

@endsection
@push('script')
    <script>
        $(document).ready(function () {

        });

        $('#select-all').change(function() {
            var checkboxes = $('tbody input[type="checkbox"]');
            checkboxes.prop('checked', $(this).prop('checked'));
        });

        // document.getElementById('form-delete').addEventListener('submit',()=>{
        //     const confirmed = confirm('Apakah anda yakin ingin melakukan delete');

        //     if(!confirmed){
        //         event.preventDefault();
        //     }
        // })
        $("#form-process-all").submit(function(e){
            const confirmed = confirm('Apakah anda yakin ingin memproses transaksi ini ?');

            if(!confirmed){
                event.preventDefault();
            }
        })
    </script>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/datatables/dataTables.bootstrap4.min.css') }}">
@endpush
