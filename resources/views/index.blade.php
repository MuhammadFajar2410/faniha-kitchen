@extends('frontend.layouts.master')
@section('title','Faniha | Home')
@section('main-content')

<!-- Start Small Banner  -->
<section class="small-banner section">
    <div class="container-fluid">
        <div class="row">
            @if($categories)
                @foreach($categories as $cat)
                    {{-- @if($cat->is_parent==1) --}}
                        <!-- Single Banner  -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-banner">
                                @if($cat->img)
                                    <img src="{{asset("backend/uploads/image/categories/$cat->img")}}" alt="{{$cat->category_name}}" width="600" height="370" lazy>
                                @else
                                    <img src="https://via.placeholder.com/600x370" alt="#">
                                @endif
                                <div class="content" >
                                    <h3>{{$cat->category_name}}</h3>
                                        <a href="{{url('product-cat',$cat->slug)}}">Discover Now</a>
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                    <!-- /End Single Banner  -->
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- Start Product Area -->
<div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Item</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @if($categories)
                                <button class="btn" style="background:black"data-filter="*">
                                    All Products
                                </button>
                                    @foreach($categories as $key=>$cat)

                                    <button class="btn" style="background:none;color:black;"data-filter=".{{$cat->id}}">
                                        {{$cat->category_name}}
                                    </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                             <!-- Start Single Tab -->
                            @if($products)
                                @foreach($products as $key=>$product)
                                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->cat_id}}">
                                    <div class="single-product">
                                        <div class="product-img">
                                            {{-- <a href="{{url('product-detail',$product->slug)}}"> --}}
                                                <img class="default-img" src="{{asset("backend/uploads/image/products/$product->img")}}" alt="{{$product->product_name}}">
                                                <img class="hover-img" src="{{asset("backend/uploads/image/products/$product->img")}}" alt="{{$product->product_name}}">
                                                @if($product->stock<=0)
                                                    <span class="out-of-stock">Sale out</span>
                                                @elseif($product->condition=='pre-order')
                                                    <span class="hot">Pre-Order</span>
                                                @elseif ($product->discount > 0)
                                                    <span class="price-dec">{{$product->discount}}% Off</span>
                                                @elseif($product->condition=='new')
                                                    <span class="new">New</span>
                                                @elseif($product->condition=='hot')
                                                    <span class="hot">Hot</span>
                                                @else
                                                    <span style="display: none"></span>
                                                @endif


                                            </a>
                                            <div class="button-head">
                                                <div class="product-action">
                                                    <a data-toggle="modal" data-target="#{{$product->slug}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Add to cart" href="{{url('add-to-cart',$product->slug)}}">Add to cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="{{url('product-detail',$product->slug)}}">{{$product->product_name}}</a></h3>
                                            <div class="product-price">
                                                @if ($product->discount > 0)
                                                    @php
                                                        $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                    @endphp
                                                        <span>{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}</span>
                                                        <del style="padding-left:4%;">{{'Rp. ' . number_format($product->price, 0, ',', '.')}}</del>
                                                @else
                                                    <span>{{'Rp. ' . number_format($product->price, 0, ',', '.')}}</span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                             <!--/ End Single Tab -->
                            @endif

                        <!--/ End Single Tab -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Product Area -->

<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($products as $product)
                        @if($product->condition=='hot')
                            <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{url('product-detail',$product->slug)}}">
                                    <img class="default-img" src="{{asset("backend/uploads/image/products/$product->img")}}" alt="{{$product->product_name}}">
                                    <img class="hover-img" src="{{asset("backend/uploads/image/products/$product->img")}}" alt="{{$product->product_name}}">
                                    {{-- <span class="out-of-stock">Hot</span> --}}
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#{{$product->slug}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                    </div>
                                    <div class="product-action-2">
                                        <a href="{{url('add-to-cart',$product->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{ url('product-detail', $product->slug) }}">{{ $product->product_name }}</a></h3>
                                <div class="product-price">
                                    @if ($product->discount > 0)
                                        @php
                                            $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        <span>{{ 'Rp. ' . number_format($after_discount, 0, ',', '.') }}</span>
                                        <span class="old">{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</span>
                                    @else
                                        <span>{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Latest Items</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($latestProduct as $product)
                        <div class="col-md-4">
                            <!-- Start Single List  -->
                            <div class="single-list">
                                <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="list-image overlay">
                                        <img src="{{asset("backend/uploads/image/products/$product->img")}}" alt="{{$product->product_name}}">
                                        <a href="{{url('add-to-cart',$product->slug)}}" class="buy"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 no-padding">
                                    <div class="content">
                                        @php
                                            $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                        @endphp
                                        @if ($product->discount > 0)
                                        <h4 class="title"><a href="#">{{$product->product_name}}</a></h4>
                                        <p class="price with-discount">{{number_format($product->discount) . "% Off"}}</p>
                                        <p class="price">{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}</p>
                                        @else
                                        <h4 class="title"><a href="#">{{$product->product_name}}</a></h4>
                                        <p class="price">{{'Rp. ' . number_format($product->price, 0, ',', '.')}}</p>
                                        @endif
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- End Single List  -->
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->


<!-- Modal -->
@if($products) @foreach($products as $key=>$product)
    <div class="modal fade" id="{{$product->slug}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="ti-close" aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row no-gutters">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <!-- Product Slider -->
              <div class="product-gallery">
                <div class="quickview-slider-active">
                  <div class="single-slider">
                    <img src="{{ asset("backend/uploads/image/products/$product->img") }}" alt="{{ $product->product_name }}">
                  </div>
                </div>
              </div>
              <!-- End Product slider -->
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
              <div class="quickview-content">
                <h2>{{$product->product_name}}</h2>
                <div class="quickview-ratting-review">
                  <div class="quickview-stock"> @if($product->stock >0) <span>
                      <i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock </span> @else <span>
                      <i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock </span> @endif </div>
                </div> @php $after_discount=($product->price-($product->price*$product->discount)/100); @endphp @if ($product->discount) <h3>
                  <small>
                    <del class="text-muted mx-2"> {{'Rp. ' . number_format($product->price, 0, ',', '.')}}</del>
                  </small>{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}
                </h3> @else <h3>{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}</h3> @endif <div class="quickview-peragraph">
                  <p>{{ $product->description }}</p>
                </div>
                <div class="size">
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <h5 class="title">Size</h5>
                      <select name="size" id="size">
                        @php
                            $sizes=explode(',',$product->size);
                        @endphp
                        @foreach($sizes as $size)
                            <option value="{{ $size }}">{{$size}}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>
                </div>
                <form action="{{url('single-add-to-cart')}}" method="POST" id="addToCart">
                  <form id="addToCart"> @csrf <div class="quantity">
                      <!-- Input Order -->
                      <div class="input-group">
                        <div class="button minus">
                          <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                            <i class="ti-minus"></i>
                          </button>
                        </div>
                        <input type="hidden" name="slug" value="{{$product->slug}}">
                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                        <div class="button plus">
                          <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                            <i class="ti-plus"></i>
                          </button>
                        </div>
                      </div>
                      <!--/ End Input Order -->
                    </div>
                    <div class="add-to-cart">
                      <button type="submit" class="btn">Add to cart</button>
                    </div>
                  </form>
                  <div class="default-social">
                    <!-- ShareThis BEGIN -->
                    <div class="sharethis-inline-share-buttons"></div>
                    <!-- ShareThis END -->
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    @endforeach
@endif

<!-- Modal end -->
@endsection


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>

@endpush
