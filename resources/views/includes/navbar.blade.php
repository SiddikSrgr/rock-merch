<nav class="navbar navbar-expand-lg navbar-light bg-white" data-aos="fade-down">
   <div class="container">
        <a class="navbar-brand" href="/"><h3 class="text-dark font-weight-bolder">Rock<span class="text-danger">Merch</span></h3></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link mx-2 {{ (request()->is('/')) ? 'active' : '' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mx-2 {{ (request()->is('categories*')) ? 'active' : '' }}" href="/categories">Categories</a>
                </li>
                @guest
                  <li class="nav-item">
                    <a class="btn btn-light nav-link mx-2 px-3" href="/login">Sign In</a>
                  </li>
                  <li class="nav-item">
                    <a class="btn btn-primary nav-link mx-2 px-3 text-white" href="/register">Sign Up</a>
                  </li>
                @endguest

                @auth
                  <li class="nav-item mx-2">
                    <a class="nav-link" href="/cart">
                      @php $carts = \App\Models\Cart::where('user_id', Auth::user()->id)->count(); @endphp
                      <img src="{{ asset('storage/icon-cart-empty.svg') }}" alt="">
                      @if($carts)
                      <div class="cart-badge">{{ $carts }}</div>
                      @endif
                    </a>
                  </li>
                  <li class="nav-item dropdown mx-2">
                    <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                      <img src="{{ asset('storage/'. Auth::user()->photo) }}" alt="" class="rounded-circle profile-picture"> Hi, {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu">
                        <a href="/transactions" class="dropdown-item">Transactions</a>
                        <a href="/account" class="dropdown-item">Account</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                  </li>
                @endauth
              </ul>
        </div>
    </div>
</nav>