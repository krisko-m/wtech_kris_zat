<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kockac')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="/assets/kocka-tab.png">
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    @yield('styles')
</head>
@yield('modals')
<body>

<!--Navbar-->
<nav class="top-navbar">
    <a href="{{ url('/') }}">
        <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="70">
    </a>

    @if(Auth::check() && Auth::user()->is_admin)
        <form class="search-wrap" role="search" method="GET" action="/admin/products">
            <div class="input-group">
                <input type="text" name="search" class="form-control rounded-pill ps-4" placeholder="Search...">
                <button class="btn position-absolute end-0 top-50 translate-middle-y pe-3" type="submit" style="z-index: 5; background: transparent; border: none;">
                    <img src="{{ asset('assets/icons/icon-search.png') }}" alt="Search" height="18">
                </button>
            </div>
        </form>
    @else
        <form class="search-wrap" role="search" method="GET" action="/products">
            <div class="input-group">
                <input type="text" name="search" class="form-control rounded-pill ps-4" placeholder="Search...">
                <button class="btn position-absolute end-0 top-50 translate-middle-y pe-3" type="submit" style="z-index: 5; background: transparent; border: none;">
                    <img src="{{ asset('assets/icons/icon-search.png') }}" alt="Search" height="18">
                </button>
            </div>
        </form>
    @endif

    <div class="d-flex align-items-center justify-content-end gap-2">

        <button class="btn btn-nav rounded-pill" data-bs-toggle="modal" data-bs-target="#accountModal">
            <img src="{{ asset('assets/icons/icon-user.png') }}" alt="User" height="40">
        </button>

        <!-- Account Modal -->
        <div class="modal fade" id="accountModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            @auth
                                <div class="fw-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                <div class="text-muted" style="font-size: 0.82rem;">{{ Auth::user()->email }}</div>
                            @else
                                <div class="fw-bold">Not Logged In</div>
                            @endauth
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-2">
                        <hr class="my-2">
                        @auth
                            @if(Auth::user()->is_admin)
                                <a href="{{ route('admin.add.product') }}" class="d-flex align-items-center gap-2 py-2 text-decoration-none" style="color: var(--accent);">
                                    Add Product
                                </a>
                                <hr class="my-2">
                            @endif

                            <a href="/account" class="d-flex align-items-center gap-2 py-2 text-decoration-none" style="color: var(--accent);">
                                Account Settings
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="d-flex align-items-center gap-2 py-2 text-decoration-none border-0 bg-transparent w-100 p-0" style="color: var(--accent);">
                                    Log Out
                                </button>
                            </form>
                        @else
                            <a href="/login" class="d-flex align-items-center gap-2 py-2 text-decoration-none" style="color: var(--accent);">
                                Log In
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <button onclick="location.href='{{ url('/cart') }}'" class="btn btn-nav rounded-pill">
            <img src="{{ asset('assets/icons/icon-trolley.png') }}" alt="Cart" height="40">
        </button>
    </div>
</nav>

<!--Categories-->
<div class="categories-bar d-flex justify-content-center">
    @auth
        @if(Auth::user()->is_admin)
            <a href="{{ url('admin/products') }}" class="cat-item">All Games</a>
        @else
            <a href="{{ url('/products') }}" class="cat-item">All Games</a>
        @endif
    @else
        {{-- This part runs for guests (is_admin is null or user not logged in) --}}
        <a href="{{ url('/products') }}" class="cat-item">All Games</a>
    @endauth

    <div class="dropdown">
        <a href="#" class="cat-item dropdown-toggle" data-bs-toggle="dropdown">Genre</a>
        <ul class="dropdown-menu">
            @if(Auth::check() && Auth::user()->is_admin)
                <li><a class="dropdown-item" href="/admin/products?genre=Family">Family</a></li>
                <li><a class="dropdown-item" href="/admin/products?genre=Puzzle">Puzzle</a></li>
                <li><a class="dropdown-item" href="/admin/products?genre=Card Games">Card Games</a></li>
                <li><a class="dropdown-item" href="/admin/products?genre=Strategic">Strategic</a></li>
                <li><a class="dropdown-item" href="/admin/products?genre=Party">Party</a></li>
            @else
                <li><a class="dropdown-item" href="/products?genre=Family">Family</a></li>
                <li><a class="dropdown-item" href="/products?genre=Puzzle">Puzzle</a></li>
                <li><a class="dropdown-item" href="/products?genre=Card Games">Card Games</a></li>
                <li><a class="dropdown-item" href="/products?genre=Strategic">Strategic</a></li>
                <li><a class="dropdown-item" href="/products?genre=Party">Party</a></li>
            @endif

        </ul>
    </div>

    <div class="dropdown">
        <a href="#" class="cat-item dropdown-toggle" data-bs-toggle="dropdown">Complexity</a>
        <ul class="dropdown-menu">
            @if(Auth::check() && Auth::user()->is_admin)
                <li><a class="dropdown-item" href="/admin/products?complexity=beginner">Beginner</a></li>
                <li><a class="dropdown-item" href="/admin/products?complexity=gateway">Gateway</a></li>
                <li><a class="dropdown-item" href="/admin/products?complexity=intermediate">Intermediate</a></li>
                <li><a class="dropdown-item" href="/admin/products?complexity=expert">Expert</a></li>
                <li><a class="dropdown-item" href="/admin/products?complexity=hardcore">Hardcore</a></li>
            @else
                <li><a class="dropdown-item" href="/products?complexity=beginner">Beginner</a></li>
                <li><a class="dropdown-item" href="/products?complexity=gateway">Gateway</a></li>
                <li><a class="dropdown-item" href="/products?complexity=intermediate">Intermediate</a></li>
                <li><a class="dropdown-item" href="/products?complexity=expert">Expert</a></li>
                <li><a class="dropdown-item" href="/products?complexity=hardcore">Hardcore</a></li>
            @endif
        </ul>
    </div>

    <div class="dropdown">
        <a href="#" class="cat-item dropdown-toggle" data-bs-toggle="dropdown">Players</a>
        <ul class="dropdown-menu">
            @if(Auth::check() && Auth::user()->is_admin)
                <li><a class="dropdown-item" href="/admin/products?players=1">Solo (1)</a></li>
                <li><a class="dropdown-item" href="/admin/products?players=2">Two Players (2)</a></li>
                <li><a class="dropdown-item" href="/admin/products?players=4">Small Group (4)</a></li>
                <li><a class="dropdown-item" href="/admin/products?players=6">Family (6)</a></li>
                <li><a class="dropdown-item" href="/admin/products?players=8">Large Group (8+)</a></li>
            @else
                <li><a class="dropdown-item" href="/products?players=1">Solo (1)</a></li>
                <li><a class="dropdown-item" href="/products?players=2">Two Players (2)</a></li>
                <li><a class="dropdown-item" href="/products?players=4">Small Group (4)</a></li>
                <li><a class="dropdown-item" href="/products?players=6">Family (6)</a></li>
                <li><a class="dropdown-item" href="/products?players=8">Large Group (8+)</a></li>
            @endif

        </ul>
    </div>
        @if(Auth::check() && Auth::user()->is_admin)
            <a href="/admin/products?sort=newest" class="cat-item">New &amp; Trending</a>
        @else
            <a href="/products?sort=newest" class="cat-item">New &amp; Trending</a>
        @endif

</div>

<!--Page Content-->
@yield('content')

<!--Footer-->
<footer class="py-4 px-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="50">
        </a>
        <div class="footer-links d-flex gap-4">
            <a href="{{route('terms-and-conditions')}}">Terms &amp; Conditions</a>
            <a href="{{ route('privacy-policy')  }}">Privacy Policy</a>
        </div>
        <div class="footer-copy">© 2026 Kockac.com · All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@yield('scripts')

</body>
</html>
