<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    @auth
                    <div class="top-left">
                        <ul class="list-main">
                            <li><i class="ti-user"></i><a href="{{ route('profile') }}">Profile</a></li>
                        </ul>
                    </div>
                    @endauth
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                <!-- Top Right -->
                <div class="right-content">
                        <ul class="list-main">
                            <li><i class="ti-location-pin"></i>
                                <a href="{{ route('track-order') }}">
                                    Track Order
                                </a>
                            </li>
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth
                                @if(Auth::user()->role == 'admin' ||  Auth::user()->role == 'seller')
                                    <li><i class="ti-book"></i> <a href="{{ route('product-backend') }}">Seller Menu</a></li>
                                    <li><i class="ti-power-off"></i> <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">Logout</a>
                                    </form></li>
                                    @elseif (Auth::user()->role == 'user')
                                    <li><i class="ti-power-off"></i> <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <a href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">Logout</a>
                                    </form></li>
                                    @endif
                            @else
                                <li><i class="ti-power-off"></i><a href="{{ route('login') }}">Login /</a><a href="{{ route('register') }}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            // $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('frontend/uploads/logo/faniha-logo-header.png') }}" alt="logo faniha">
                        </a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="javascript:void(0);" onclick="toggleSearch()"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form" method="POST" action="{{ route('product-search') }}">
                                @csrf
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option >All Category</option>
                                @php
                                    $categories=DB::table('categories')->where('status',true)->get();
                                @endphp
                                @foreach ($categories as $category )
                                <option>{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product-search')}}">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            @php
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                        @php
                                            $carts = \App\Models\Cart::getCartProducts(Auth::id())
                                        @endphp
                                            @foreach($carts as $cart)
                                                    <li>
                                                        <a class="cart-img" href="#"><img src="{{asset("backend/uploads/image/products/" . $cart->products->img)}}" alt="{{$cart->products->product_name}}"></a>
                                                        <h4><a href="{{url('product-detail',$cart->products['slug'])}}" target="_blank">{{$cart->products['product_name']}}</a></h4>
                                                        <p class="quantity">{{$cart->quantity}} x - <span class="amount">{{'Rp ' . number_format($cart->price, 0, ',', '.')}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                        </div>
                                        {{-- <a href="{{route('cart')}}" class="btn animate">Cart</a> --}}
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="sinlge-bar shopping">
                            @php
                                $cart_count = DB::table('carts')->where('user_id', Auth::id())->where('order_number', null)->distinct('product_id')->count('product_id');
                            @endphp
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{$cart_count}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{$cart_count}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                            @foreach($carts as $cart)
                                            <li>
                                                <a href="{{route('cart-delete',$cart->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="{{route('product-detail',$cart->products['slug'])}}"><img src="{{asset("backend/uploads/image/products/" . $cart->products->img)}}" alt="{{$cart->products->product_name}}"></a>
                                                <h4><a href="{{route('product-detail',$cart->products['slug'])}}">{{$cart->products['product_name']}}</a></h4>
                                                <p class="quantity">{{$cart->quantity}} x - <span class="amount">{{'Rp ' . number_format($cart->price, 0, ',', '.')}}</span></p>
                                            </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            @php
                                                $total_price = DB::table('carts')->where('user_id', Auth::id())->where('order_number', null)->sum('amount');
                                            @endphp
                                            <span>Total</span>
                                            <span class="total-amount">{{'Rp ' . number_format($total_price, 0, ',', '.')}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            {{-- <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li> --}}
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{route('product-grids')}}">Products</a><span class="new">New</span></li>
                                            <li class="normal-none @if(Request::path()=='track-order')  active  @endif"><a href="{{route('track-order')}}">Order Track</a></li>
                                            @auth
                                                @if(Auth::user()->role == 'admin' ||  Auth::user()->role == 'seller')
                                                <li class="normal-none"><a href="{{route('product-backend')}}">Seller Menu</a></li>
                                                @endif
                                                <li class="normal-none"><a href="{{route('profile')}}">Profile</a></li>
                                                <li class="normal-none"><form id="logoutForm2" action="{{ route('logout') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <a href="javascript:void(0);" onclick="document.getElementById('logoutForm2').submit();">Logout</a>
                                                </form></li>
                                            @else
                                                <li><a href="{{ route('login') }}">Login</a></li>
                                                <li><a href="{{ route('register') }}">Register</a></li>
                                            @endauth
                                            {{-- <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
