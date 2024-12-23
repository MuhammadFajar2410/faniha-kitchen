<!DOCTYPE html>
<html lang="en">
<head>
	@include('frontend.layouts.head')

    @stack('css')

</head>
<body class="js">


	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')

	@include('frontend.layouts.footer')
    <div class="script">
        @stack('script')
    </div>
</body>
</html>
