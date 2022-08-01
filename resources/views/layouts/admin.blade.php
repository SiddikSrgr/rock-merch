<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Rock Merch Dashboard @yield('title')</title>

    <!-- Bootstrap CSS -->
    @stack('prepend-style')
    <link href="/vendor/css/style.css" rel="stylesheet">
    <link href="/vendor/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css"/>
    @stack('addon-style')

  </head>
  <body>

    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand px-3" href="/"><h5>ADMINISTRATOR</h5></a>
        <button class="navbar-toggler d-md-none collapsed " type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0"> 
                <ul class="nav flex-column list-group list-group-flush">
                    <li class="nav-item list-group-item {{ (request()->is('admin/dashboard*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/dashboard"><i class="bi bi-house-door"></i> Dashboard</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/transactions*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/transactions"><i class="bi bi-cart3"></i> Transactions</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/confirmations*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/confirmations"><i class="bi bi-currency-dollar"></i> Confirmations</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/shippings*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/shippings"><i class="bi bi-truck"></i> Shippings</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/category*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/category"><i class="bi bi-tag"></i> Categories</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/size*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/size"><i class="bi bi-aspect-ratio"></i> Sizes</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/product*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/product"><i class="bi bi-card-list"></i> Products</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/stock*')) ? 'active' : '' }}">
                        <a class="nav-link text-dark" href="/admin/stock"><i class="bi bi-list-ol"></i> Product Stocks</a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/account*')) ? 'active' : '' }}">
                        <a href="/admin/account" class="nav-link text-dark">
                            <i class="bi bi-person"></i> Account
                        </a>
                    </li>
                    <li class="nav-item list-group-item {{ (request()->is('admin/user*')) ? 'active' : '' }}">
                        <a href="/admin/user" class="nav-link text-dark">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li class="nav-item list-group-item">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-dark">
                            <i class="bi bi-box-arrow-left"></i> Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>

            <!-- Section Content -->
            @yield('content')

        </div>
    </div>

    <footer class="footer bg-light py-3 mt-3">
        <div class="container text-center">
        <span class="text-muted">@2022 All Right Reserved</span>
        </div>
    </footer>

    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>
    <script src="/vendor/js/bootstrap.bundle.min.js"></script>
    @stack('addon-script')
  </body>
</html> 