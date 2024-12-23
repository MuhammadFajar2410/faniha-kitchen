<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
      <div class="sidebar-brand-icon">Seller Menu
      </div>
      <div class="sidebar-brand-text mx-3">
      </div>
    </a>
    <!-- Divider -->
    <!-- Heading -->
    @auth
        @if (auth()->user()->role === 'admin')
    <hr class="sidebar-divider" />
    <div class="sidebar-heading">Admin Only</div>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#admin" aria-expanded="true" aria-controls="admin">
        <i class="fas fa-fw fa-cog"></i>
        <span>Admin</span>
      </a>
      <div id="admin" class="collapse" aria-labelledby="admin" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('brands') }}">Brands</a>
            <a class="collapse-item" href="{{ route('categories') }}">Categories</a>
            <a class="collapse-item" href="{{ route('all-products') }}">All Products</a>
            <a class="collapse-item" href="{{ route('all-users') }}">User Management</a>
        </div>
      </div>
    </li>
    <hr class="sidebar-divider" />
    <div class="sidebar-heading">Seller</div>
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pesanan" aria-expanded="true" aria-controls="pesanan">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Data Orders</span>
      </a>
      <div id="pesanan" class="collapse" aria-labelledby="pesanan" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{ route('product-backend') }}">My Product</a>
          <a class="collapse-item" href="{{ route('order-lists') }}">Orders</a>
      </div>
    </li>
    @elseif (auth()->user()->role === 'seller' )
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pesanan" aria-expanded="true" aria-controls="pesanan">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Seller Menu</span>
      </a>
      <div id="pesanan" class="collapse" aria-labelledby="pesanan" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{ route('product-backend') }}">My Product</a>
          <a class="collapse-item" href="{{ route('order-lists') }}">Orders</a>
        </div>
      </div>
    </li>
        @endif
    @endauth
    <!-- Divider -->
    <hr class="sidebar-divider" />
    <!-- Heading -->
    <div class="sidebar-heading">Auth</div>
    @auth
    <li class="nav-item">
      <form action="/logout" method="POST" style="display: none;" id="logoutForm"> @csrf </form>
      <a class="nav-link" href="#" onclick="document.getElementById('logoutForm').submit();">
        <i class="fas fa-fw fa-power-off"></i>
        <span>Log Out</span>
      </a>
    </li>
    @endauth
    @if (!auth()->check())
    <li class="nav-item">
      <a href="{{ url('login') }}" class="nav-link">
        <i class="fas fa-fw fa-sign-in-alt"></i>
        <span>Login</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('register') }}" class="nav-link">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Register</span>
      </a>
    </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>

  <!-- End of Sidebar -->
