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
                            <li class="active"><a href="javascript:void(0);">Order Detail</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5" style="height:max-content">
    <div class="container">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-hover table-striped">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td colspan="6">{{ $order->name }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td colspan="6">{{ $order->phone }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td colspan="6">{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td colspan="6">{{ strtoupper($order->payment_method) }}</td>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Brand</th>
                            <th>Product</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    @foreach ($carts as $cart)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cart->brand->brand_name }}</td>
                            <td>{{ $cart->products->product_name }}</td>
                            <td>{{ $cart->order_status }}</td>
                            <td>{{ $cart->payment_status }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>{{ 'Rp. ' . number_format($cart->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="6" style="text-align:center;font-weight:bold;">Total</td>
                            <td style="font-weight: bold">{{ 'Rp. ' . number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@push('stack')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
@endpush
