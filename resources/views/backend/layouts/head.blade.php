<!-- Meta Tag -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Title Tag  -->
<title>@yield('title')</title>
<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('backend/uploads/image/logo/faniha-icon.png') }}">
<!-- Web Font -->
<link rel="stylesheet" href="{{ asset('frontend/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/sbadmin2/css/sb-admin-2.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

<style>
/* Multilevel dropdown */
.dropdown-submenu {
position: relative;
}

.dropdown-submenu>a:after {
content: "\f0da";
float: right;
border: none;
font-family: 'FontAwesome';
}

.dropdown-submenu>.dropdown-menu {
top: 0;
left: 100%;
margin-top: 0px;
margin-left: 0px;
}

/**/
</style>

