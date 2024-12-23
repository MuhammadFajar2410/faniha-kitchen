@extends('backend.layouts.master')
@section('title','Faniha | Order Detail')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-muted">Order Number - {{ $order->order_number }}</h5>
    </div>
    <div class="card-body">
        <div class="table">
            <form action="{{ route('single-process',['order_number' => $order->order_number]) }}" method="POST" id="single-process">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <table>
                            <tr>
                                <td class="detail" style="border: none">Name</td>
                                <td class="detail" style="border: none">:</td>
                                <td class="detail" style="border: none">{{ $order->name }}</td>
                            </tr>
                            <tr>
                                <td class="detail" style="border: none">Phone</td>
                                <td class="detail" style="border: none">:</td>
                                <td class="detail" style="border: none">{{ $order->phone}}</td>
                            </tr>
                            <tr>
                                <td class="detail" style="border: none">Address</td>
                                <td class="detail" style="border: none">:</td>
                                <td class="detail" style="border: none">{{ $order->address}}</td>
                            </tr>
                            <tr>
                                <td class="detail" style="border: none">Payment Method</td>
                                <td class="detail" style="border: none">:</td>
                                <td class="detail" style="border: none">{{ ucwords($order->payment_method)}}</td>
                            </tr>
                            @if ($order->payment_method === 'cod')
                                <tr>
                                    <td class="detail" style="border: none">Payment Status</td>
                                    <td class="detail" style="border: none">:</td>
                                    <td class="detail" style="border: none">
                                        <select name="payment_status" class="form-control">
                                            <option value="unpaid" {{ !$cart->payment_status == 'paid' ? 'selected' : '' }}>Unpaid</option>
                                            <option value="paid" {{ $cart->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        </select>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="detail" style="border: none">Payment Status</td>
                                    <td class="detail" style="border: none">:</td>
                                    <td class="detail" style="border: none">{{ ucwords($cart->payment_status)}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="detail" style="border: none">Order Status</td>
                                <td class="detail" style="border: none">:</td>
                                <td class="detail" style="border: none">

                                    <select name="order_status" class="form-control">
                                        @foreach ($status_opt as $value => $label )
                                            <option value="{{ $value }}" {{ $cart->order_status == $value ? 'selected' : '' }}>{{ ucwords($value) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="detail">Product Name</td>
                                    <td class="detail">Quantity</td>
                                    <td class="detail">Price</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td class="tddetail">{{ $cart->product_name }}</td>
                                        <td class="tddetail">{{ $cart->quantity }}</td>
                                        <td class="tddetail">{{ 'Rp. ' . number_format($cart->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="tddetail bg-primary text-white">Total  </td>
                                    <td class="tddetail bg-primary text-white">{{ 'Rp. ' . number_format($total->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="offset-10 col">
                        <a href="{{ route('order-lists') }}" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary">Process</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('style')
    <style>
        .detail {
            font-size: 1.2rem;
        }
        .tddetail {
            font-weight: bold;
        }

        .tddetail.total {
            /* background-color: blue; */
        }
    </style>
@endpush
