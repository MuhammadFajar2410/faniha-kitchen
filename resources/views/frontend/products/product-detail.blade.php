@extends('frontend.layouts.master')

@section('meta')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
	<meta name="description" content="{{$product_detail->description}}">
	<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
	<meta property="og:type" content="article">
	<meta property="og:title" content="{{$product_detail->product_name}}">
	<meta property="og:image" content="{{$product_detail->img}}">
	<meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','Faniha | Product')
@section('main-content')

		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="">Shop Details</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->

		<!-- Shop Single -->
		<section class="shop single section">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="row">
									<div class="col-lg-6 col-12">
										<!-- Product Slider -->
										<div class="product-gallery">
											<!-- Images slider -->
											<div class="flexslider-thumbnails">
												<ul class="slides">
													{{-- @foreach($product_detail as $data) --}}
														<li data-thumb="{{asset("backend/uploads/image/products/$product_detail->img")}}" rel="adjustX:10, adjustY:">
															<img src="{{asset("backend/uploads/image/products/$product_detail->img")}}" alt="{{$product_detail->product_name}}">
														</li>
													{{-- @endforeach --}}
												</ul>
											</div>
											<!-- End Images slider -->
										</div>
										<!-- End Product slider -->
									</div>
									<div class="col-lg-6 col-12">
										<div class="product-des">
											<!-- Description -->
											<div class="short">
												<h4>{{$product_detail->product_name}}</h4>
                                                @php
                                                    $after_discount=('Rp. ' . number_format( $product_detail->price-(($product_detail->price*$product_detail->discount)/100), 0, ',', '.'));
                                                @endphp
                                                @if ($product_detail->discount)
												    <p class="price"><span class="discount">{{$after_discount}}</span><s>{{'Rp. ' . number_format($product_detail->price, 0, ',', '.')}}</s> </p>
                                                @else
												    <p class="price"><span class="discount">{{'Rp. ' . number_format($product_detail->price, 0, ',', '.')}}</span></p>
                                                @endif
												<p class="description">{!!($product_detail->description)!!}</p>
											</div>
											<!--/ End Description -->
											<!-- Size -->
											@if($product_detail->size)
												<div class="size mt-4">
													<h4 class="title">Size</h4>
                                                    <select name="size" id="size">
														@php
															$sizes=explode(',',$product_detail->size);
															// dd($sizes);
														@endphp
														@foreach($sizes as $size)
                                                            <option value="{{ $size }}">{{$size}}</option>
														@endforeach
                                                    </select>
												</div>
											@endif
											<!--/ End Size -->
											<!-- Product Buy -->
											<div class="product-buy">
												<form action="{{route('single-add-to-cart')}}" method="POST">
													@csrf
													<div class="quantity">
														<h6>Quantity :</h6>
														<!-- Input Order -->
														<div class="input-group">
															<div class="button minus">
																<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
																	<i class="ti-minus"></i>
																</button>
															</div>
															<input type="hidden" name="slug" value="{{$product_detail->slug}}">
															<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity">
															<div class="button plus">
																<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
																	<i class="ti-plus"></i>
																</button>
															</div>
														</div>
													<!--/ End Input Order -->
													</div>
													<div class="add-to-cart mt-4">
														<button type="submit" class="btn">Add to cart</button>
													</div>
												</form>

												<p class="cat">Category :<a href="{{route('product-cat',$product_detail->slug)}}">{{$product_detail->product_name}}</a></p>
												<p class="availability">Stock : @if($product_detail->stock>0)<span class="badge badge-success">{{$product_detail->stock}}</span>@else <span class="badge badge-danger">{{$product_detail->stock}}</span>  @endif</p>
											</div>
											<!--/ End Product Buy -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="product-info">
											<div class="nav-main">
												<!-- Tab Nav -->
												<ul class="nav nav-tabs" id="myTab" role="tablist">
													<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a></li>
												</ul>
												<!--/ End Tab Nav -->
											</div>
											<div class="tab-content" id="myTabContent">
												<!-- Description Tab -->
												<div class="tab-pane fade show active" id="description" role="tabpanel">
													<div class="tab-single">
														<div class="row">
															<div class="col-12">
																<div class="single-des">
																	<p>{!! ($product_detail->description) !!}</p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--/ End Description Tab -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</section>
		<!--/ End Shop Single -->

		<!-- Start Most Popular -->
	<div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>Related Products</h2>
					</div>
				</div>
            </div>
            <div class="row">
                    {{-- {{$product_detail->rel_prods}} --}}
                    <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($related_products as $product)
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
										<a href="{{route('product-detail',$product->slug)}}">
                                            <img class="default-img" src="{{asset("backend/uploads/image/products/$product->img")}}" alt="{{$product->product_name}}">
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
                                                <a title="Add to cart" href="#">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->product_name}}</a></h3>
                                        <div class="product-price">
                                            @php
                                                $after_discount=($product->price-(($product->discount*$product->price)/100));
                                            @endphp
                                            @if ($product->discount)
                                                <span class="old">{{'Rp. ' . number_format($product->price, 0, ',', '.')}}</span>
                                                <span>{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}</span>
                                            @else
                                                <span>{{'Rp. ' . number_format($product->price, 0, ',', '.')}}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <!-- End Single Product -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- End Most Popular Area -->


  <!-- Modal -->
  @if($related_products)
        @foreach($related_products as $key=>$product)
            <div class="modal fade" id="{{$product->slug}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
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
                                                <div class="quickview-stock">
                                                    @if($product->stock >0)
                                                        <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                    @else
                                                        <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100);
                                            @endphp
                                            @if ($product->discount)
                                                <h3><small><del class="text-muted mx-2"> {{'Rp. ' . number_format($product->price, 0, ',', '.')}}</del></small>{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}</h3>
                                            @else
                                                <h3>{{'Rp. ' . number_format($after_discount, 0, ',', '.')}}</h3>
                                            @endif

                                            <div class="quickview-peragraph">
                                                <p>{{ $product->description }}</p>
                                            </div>
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Size</h5>
                                                        <select name="size" id="size">
                                                            @php
                                                            $sizes=explode(',',$product->size);
                                                        //    dd($sizes);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option value="{{ $size }}">{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{route('single-add-to-cart')}}" method="POST" id="addToCart">
                                            <form id="addToCart">
                                                @csrf
                                                <div class="quantity">
                                                    <!-- Input Order -->
                                                    <div class="input-group">
                                                        <div class="button minus">
                                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="slug" value="{{$product->slug}}">
                                                        <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
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
                                                    <a href="{{url('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                                </div>
                                            </form>
                                            <div class="default-social">
                                            <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
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

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
