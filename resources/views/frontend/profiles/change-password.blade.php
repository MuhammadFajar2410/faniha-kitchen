@extends('frontend.layouts.master')

@section('title','Faniha | Profile')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li><a href="{{ route('profile') }}">Profile<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- End Breadcrumbs -->
    <section class="shop checkout section">
        <div class="container">
                <form class="form" method="POST" action="{{ route('update-password') }}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="checkout-form">
                                <!-- Form -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Old Password<span>*</span></label>
                                            <input type="password" id="old_password" name="old_password" autocomplete required>
                                            @error('old_password')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label>New Password<span>*</span></label>
                                            <input type="password" name="new_password" autocomplete required>
                                            @error('new_password')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Confirm Password<span>*</span></label>
                                            <input type="password" name="new_password_confirmation" autocomplete required>
                                            @error('new_password_confirmation')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Form -->
                            </div>
                            <button type="submit" class="btn">Save</button>
                            <a class="btn" href="{{ route('profile') }}" id="back">Back</a>
                        </div>
                    </div>
                </form>
        </div>
    </section>
@endsection
@push('css')
    <style>
        #back {
            color: #fff;
            display: inline-block;
            padding: 8px 32px;
            border-radius: 0;
        }
    </style>
@endpush
