<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kockac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="/css/productoverview.css" />
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
    <link rel="icon" type="image/x-icon" href="/assets/kocka-tab.png">
</head>
<body>

<!--Navbar-->
<nav class="top-navbar">
    <a href="{{ url('/') }}">
        <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="70">
    </a>

    <form class="search-wrap" role="search" method="GET" action="/products">
        <div class="input-group">
            <input type="text" name="search" class="form-control rounded-pill ps-4" placeholder="Search...">
            <button class="btn position-absolute end-0 top-50 translate-middle-y pe-3" type="submit" style="z-index: 5; background: transparent; border: none;">
                <img src="{{ asset('assets/icons/icon-search.png') }}" alt="Search" height="18">
            </button>
        </div>
    </form>

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
                                <div class="fw-bold">{{ Auth::user()->name }}</div>
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
                            <hr class="my-2">
                            <a href="{{ url('/admin/login') }}" class="d-flex align-items-center gap-2 py-2 text-decoration-none" style="color: var(--accent);">
                                Admin Log In
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
    <a href="{{ url('/products') }}" class="cat-item">All Games</a>

    <div class="dropdown">
        <a href="#" class="cat-item dropdown-toggle" data-bs-toggle="dropdown">Genre</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Family</a></li>
            <li><a class="dropdown-item" href="#">Puzzle</a></li>
            <li><a class="dropdown-item" href="#">Card Games</a></li>
            <li><a class="dropdown-item" href="#">Strategic</a></li>
            <li><a class="dropdown-item" href="#">Party</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <a href="#" class="cat-item dropdown-toggle" data-bs-toggle="dropdown">Complexity</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Beginner</a></li>
            <li><a class="dropdown-item" href="#">Gateway</a></li>
            <li><a class="dropdown-item" href="#">Intermediate</a></li>
            <li><a class="dropdown-item" href="#">Expert</a></li>
            <li><a class="dropdown-item" href="#">Hardcore</a></li>
        </ul>
    </div>

    <div class="dropdown">
        <a href="#" class="cat-item dropdown-toggle" data-bs-toggle="dropdown">Players</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Solo</a></li>
            <li><a class="dropdown-item" href="#">Two Players</a></li>
            <li><a class="dropdown-item" href="#">Small Group</a></li>
            <li><a class="dropdown-item" href="#">Family</a></li>
            <li><a class="dropdown-item" href="#">Large Group</a></li>
        </ul>
    </div>

    <a href="#" class="cat-item">New &amp; Trending</a>
</div>

<!--Main-->
<main class="container-fluid px-4 my-4">
    <form method="GET" action="/products" id="filterForm">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <input type="hidden" name="sort" id="sortInput" value="{{ request('sort', 'default') }}">
        <input type="hidden" name="page" id="pageInput" value="{{ request('page', 1) }}">
        <div class="row gap-4">

            <!--Sidebar-->
            <div class="col-md-2 filter-sidebar">
                <button type="submit" class="login-button d-block mx-auto w-75 mt-3 fs-6"
                        onclick="document.getElementById('pageInput').value=1; document.getElementById('filterForm').submit();">Apply Filters</button>

                <a href="/products" class="sort-item w-100 mt-2 text-center d-block">Reset</a>
                <!-- Price -->
                <div class="filter-section">
                    <div class="filter-label">Price</div>
                    <div class="d-flex gap-2 mb-2">
                        <input type="number" name="price_min" class="form-control filter-input"
                               placeholder="€ {{ request('price_min') }}" min="0" value="{{ request('price_min') }}">
                        <input type="number" name="price_max" class="form-control filter-input"
                               placeholder="€ {{ request('price_max')}}" max="300" value="{{ request('price_max') }}">
                    </div>
                    <input type="range" class="form-range" min="0" max="300" value="0">
                    <input type="range" class="form-range" min="0" max="300" value="300" style="direction: rtl;">
                </div>

                <!-- Number of Players -->
                <div class="filter-section">
                    <div class="filter-label">Number of Players</div>
                    <input type="number" name="players" class="form-control filter-input text-center" placeholder="{{request('players')}}"
                           value="{{request('players')}}" min="1">
                    <input type="range" class="form-range mt-2" min="0" max="20" value="0">
                </div>

                <!-- Age -->
                <div class="filter-section">
                    <div class="filter-label">Age</div>
                    <div class="filter-checks">
                        @foreach([6, 8, 10, 12, 14, 16, 18] as $age)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="ages[]" value="{{ $age }}"
                                       id="age{{ $age }}"
                                    {{ in_array($age, request('ages', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="age{{ $age }}">{{ $age }}+</label>
                            </div>
                        @endforeach
                    </div>
                </div>

{{--                <!-- Author -->--}}
{{--                <div class="filter-section">--}}
{{--                    <div class="filter-label">Author</div>--}}
{{--                    <div class="filter-checks" id="authorChecks">--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="albi">--}}
{{--                            <label class="form-check-label" for="albi">ALBI</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="boardbros">--}}
{{--                            <label class="form-check-label" for="boardbros">Boardbros</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="dino">--}}
{{--                            <label class="form-check-label" for="dino">Dino</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="hasbro">--}}
{{--                            <label class="form-check-label" for="hasbro">Hasbro</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="piatnik">--}}
{{--                            <label class="form-check-label" for="piatnik">Piatnik</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <a href="#" class="filter-more">More</a>--}}
{{--                </div>--}}

            </div>

            <!--Products-->
            <div class="col">

                <!-- Sort bar -->
                <div class="sort-bar d-flex gap-3 mb-4">
                    <a href="#" class="sort-item {{ request('sort', 'default') === 'default' ? 'active' : '' }}"
                       onclick="setSort('default'); return false;">Favourite</a>
                    <a href="#" class="sort-item {{ request('sort') === 'price_asc' ? 'active' : '' }}"
                       onclick="setSort('price_asc'); return false;">Cheapest</a>
                    <a href="#" class="sort-item {{ request('sort') === 'price_desc' ? 'active' : '' }}"
                       onclick="setSort('price_desc'); return false;">Priciest</a>
                    <a href="#" class="sort-item {{ request('sort') === 'name_asc' ? 'active' : '' }}"
                       onclick="setSort('name_asc'); return false;">A-Z</a>
                </div>


                <!-- Product grid -->
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-3">

                    @foreach($products as $product)
                        <div class="col">
                            <a href="/products/{{ $product->product_id }}" class="product-card">
                                <div class="product-img">
                                    @if($product->mainImage)
                                        <img src="{{ $product->mainImage->image_path }}" alt="{{ $product->name }}">
                                    @endif
                                </div>
                                <div class="p-3">
                                    <div class="product-name mb-1"> {{ $product->name }}</div>
                                    <div class="product-price"> {{$product->price}} €</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pages -->
                <div class="d-flex justify-content-end mt-4 pb-4">
                    <nav>
                        <ul class="pagination overview-pagination">
                            {{ $products->links() }}
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </form>
</main>

<!--Footer-->
<footer class="py-4 px-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="50">
        </a>
        <div class="footer-links d-flex gap-4">
            <a href="#">Terms &amp; Conditions</a>
            <a href="#">Privacy Policy</a>
        </div>
        <div class="footer-copy">© 2026 Kockac.com · All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    function setSort(value) {
        document.getElementById('sortInput').value = value;

        const pageInput = document.getElementById('pageInput');
        if (pageInput) pageInput.value = 1;

        document.getElementById('filterForm').submit();
    }
</script>
</body>
</html>
