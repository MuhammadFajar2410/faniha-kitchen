@extends('frontend.layouts.master')

@section('title','Faniha | Payment')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Payment</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
                <form class="form" method="POST" action="{{route('checkout-cod',['order_number' => $order->order_number])}}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <div class="checkout-form">
                                <h2>Confirm Order</h2>
                                <p>Please review your order information to ensure its accurate.</p>
                                <!-- Form -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nama<span>*</span></label>
                                            <input type="text" id="name" name="name" value="{{ $order->name }}" disabled>
                                            @error('name')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nomor Telepon<span>*</span></label>
                                            <input type="number" name="phone" placeholder="" required value="{{ $order->phone }}" min="0" disabled>
                                            @error('phone')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Alamat<span>*</span></label>
                                            <textarea name="address" cols="30" rows="2" class="form-control" disabled>{{ $order->address }}</textarea>
                                            {{-- <input type="text" name="address1" placeholder="" value="{{old('address1')}}"> --}}
                                            @error('address1')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Form -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="order-details">
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>CART  TOTALS</h2>
                                    <div class="content">
                                        <ul>
										    <li class="order_subtotal" data-price="{{$total_price}}">Cart Total<span>{{'Rp ' . number_format($total_price, 0, ',', '.')}}</span></li>

                                            @if(session('coupon'))
                                            <li class="coupon_price" data-price="{{session('coupon')['value']}}">You Save<span>{{'Rp ' . number_format(session('coupon')['value'], 0, ',', '.')}}</span></li>
                                            @endif
                                            {{-- @php
                                                $total_amount=Helper::totalCartPrice();
                                                if(session('coupon')){
                                                    $total_amount=$total_amount-session('coupon')['value'];
                                                }
                                            @endphp
                                            @if(session('coupon'))
                                                <li class="last"  id="order_total_price">Total<span>{{'Rp ' . number_format($total_amount, 0, ',', '.')}}</span></li>
                                            @else
                                                <li class="last"  id="order_total_price">Total<span>{{'Rp ' . number_format($total_amount, 0, ',', '.')}}</span></li>
                                            @endif --}}
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Payment Method Widget -->
                                <div class="single-widget payement">
                                    <div class="content">
                                        {{-- <div class="contoh-status">Contoh status : <input type="text" id="status" value=""></div> --}}
                                        @if ($order->payment_method === 'midtrans')
                                        <img src="{{asset("frontend/uploads/img/payments/payment-method.png")}}" alt="peyment-method">
                                        @endif
                                    </div>
                                </div>
                                <!--/ End Payment Method Widget -->
                                <!-- Button Widget -->
                                <div class="single-widget get-button">
                                    <div class="content">
                                        <div class="button">
                                            @if ($order->payment_method === 'midtrans')
                                                <button class="btn" id="pay-button">Pay NOW</button>
                                            @elseif($order->payment_method === 'cod')
                                                <button type="submit" class="btn checkout-cod">Confirm</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Button Widget -->
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </section>
    <!--/ End Checkout -->
@endsection
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        $("#pay-button").click(function(){
            event.preventDefault();
            snap.pay('{{ $cart->snap_token }}', {
                    // Optional
                    onSuccess: function(){
                        window.location.href = '/payment-success/{{ $order->order_number }}'

                    },
                    // Optional
                    onPending: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
        })
    </script>
@endpush
