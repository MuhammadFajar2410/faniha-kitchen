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
                            <li class="active"><a href="javascript:void(0);">Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- End Breadcrumbs -->
    <section class="shop checkout section">
        <div class="container">
                <form class="form" method="POST" action="{{ route('update-profile') }}">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="checkout-form">
                                <!-- Form -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Name<span>*</span></label>
                                            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                                            @error('name')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-md-4 col-12">
                                        <div class="form-group">
                                            <label>Phone Number <span class="text-muted" style="position:unset; font-size:0.7rem; font-style:italic">(example : 089409849482)</span></label>
                                            <input type="number" name="phone" min="0" value="{{ $user->phone ?? '' }}">
                                            @error('phone')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Alamat<span></span></label>
                                            <textarea name="address" cols="30" rows="2" class="form-control">{{ $user->address ?? '' }}</textarea>
                                            {{-- <input type="text" name="address1" placeholder="" value="{{old('address1')}}"> --}}
                                            @error('address1')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Form -->
                            </div>
                            <button type="submit" class="btn">Save</button>
                            <a class="btn btn-change" href="{{ route('change-password') }}" id="changePassword">Change Password</a>
                        </div>
                    </div>
                </form>
        </div>
    </section>
@endsection
@push('css')
    <style>
        #changePassword {
            color: #fff;
            display: inline-block;
            padding: 8px 32px;
            border-radius: 0;
        }
    </style>
@endpush
