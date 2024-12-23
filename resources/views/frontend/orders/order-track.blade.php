@extends('frontend.layouts.master')

@section('title','Faniha | Order Track')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Order Track</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Order Number</td>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Payment Method</td>
                    <td>Payment Status</td>
                    <td>Status</td>
                    <td>View</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ 'Rp. ' . number_format($order->total_amount, 0, ',' , '.') }}</td>
                    <td>{{ strtoupper($order->payment_method) }}</td>
                    <td>
                        @if ($order->cart->contains('payment_status', 'unpaid'))
                            <div class="badge bg-danger text-white pill">unpaid</div>
                        @else
                            <div class="badge bg-success text-white pill">paid</div>
                        @endif
                    </td>
                    <td>
                        @php
                            $classStatus = 'bg-secondary';

                            if ($order->cart->contains('order_status', 'new')) {
                                $classStatus = 'bg-success';
                            } elseif ($order->cart->contains('order_status', 'process')) {
                                $classStatus = 'bg-warning';
                            } elseif ($order->cart->contains('order_status', 'delivered')) {
                                $classStatus = 'bg-primary';
                            } elseif ($order->cart->contains('order_status', 'cancel')) {
                                $classStatus = 'bg-danger';
                            }
                        @endphp
                            <div class="badge {{ $classStatus }} text-white pill" >{{ $order->cart->first()->order_status }}</div>
                    </td>
                    <td>
                        @if ($order->cart->first()->status === 'payment')
                            <a href="{{ route('chekout-payment', ['order_number' => $order->order_number]) }}" style="border-radius: 2rem; color : #000;display:block; margin-left:.6rem;"><i class="ti-eye"></i></a>
                        @elseif ($order->cart->first()->status === 'success' || 'cancel')
                            <a href="{{ url("track-order/$order->order_number") }}" style="border-radius: 2rem; color : #000;display:block; margin-left:.6rem;"><i class="ti-eye"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
@push('stack')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
@endpush
