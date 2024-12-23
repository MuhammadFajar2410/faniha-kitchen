<!DOCTYPE html>
<html lang="en">
    <head>

        @stack('meta')
        @stack('style')
        @section('title', 'Faniha | Dashboard')
        @include('backend.layouts.head')
    </head>

    <body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('backend.layouts.sidebar')
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav
                        class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
                    >
                        <!-- Sidebar Toggle (Topbar) -->
                        <button
                            id="sidebarToggleTop"
                            class="btn btn-link d-md-none rounded-circle mr-3"
                        >
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            @include('backend.layouts.user-profile')
                        </ul>
                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid" style="min-height: 80vh">
                        @include('backend.layouts.notification')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
        @include('backend.layouts.footer')
        <div class="script">
            @include('backend.layouts.script')
            @stack('script')
        </div>
    </body>
</html>
