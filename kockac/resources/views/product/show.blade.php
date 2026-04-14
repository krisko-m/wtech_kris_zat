<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kockac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="/assets/kocka-tab.png">
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
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

<main class="container my-5">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!--Product Section-->
    <div class="row justify-content-center product-container">
        <!--Photos-->
        <div class="col-md-5 d-flex flex-row align-items-center mb-4">
            <div class="d-flex flex-column mb-3">
                @foreach($product->images as $image)
                    <img src="{{ $image->image_path }}" alt="Product photo" class="img-fluid secondary-photo my-2"
                         onclick="changeMainImage('{{ $image->image_path }}', this)">
                @endforeach
            </div>
            <div class="d-flex flex-column mb-3 align-items-center">
                <img id="main-photo" src="{{ $product->images->where('is_main', true)->first()->image_path ?? '/assets/product-bang-1.png' }}" alt="Main product photo" class="main-photo">
                <div class="d-flex flex-row gap-2 mt-4">
                    @foreach($product->images as $index => $image)
                        <button class="dot {{ $index === 0 ? 'active' : '' }}" onclick="setActiveDot(this)"></button>
                    @endforeach
                </div>
            </div>
        </div>

        <!--Product Info-->
        <div class="col-md-7 product-info d-flex flex-column gap-3 mb-4">
            <h1 class="product-name align-items-left">{{ $product->name }}</h1>
            <p class="product-description">{{ substr($product->description, 0, 150) }}...
                <a href="#description" class="expandable-text">Show more</a>
            </p>

            @if($product->genres->count() > 0)
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($product->genres as $genre)
                        <span class="badge bg-secondary">{{ $genre->genre_type }}</span>
                    @endforeach
                </div>
            @endif

            <!--Details Card-->
            <div class="w-110 detail-card">
                <div class="row w-120">
                    <div class="col-4 d-flex flex-column gap-2">
                        <span class="detail-label">Recommended age:</span>
                        <span class="detail-value">{{ $product->recommended_age ?? 'N/A' }}+</span>
                    </div>
                    <div class="col-4 d-flex flex-column gap-2">
                        <span class="detail-label">Duration of a game:</span>
                        @if(($product->duration_min == $product->duration_max) && $product->duration_max != null)
                            <span class="detail-value">{{ $product->duration_min }} min</span>
                        @elseif(($product->duration_min != $product->duration_max) && ($product->duration_max != null) && $product->duration_min != null)
                            <span class="detail-value">{{ $product->duration_min }} to {{ $product->duration_max }} min</span>
                        @else
                            <span class="detail-value">N/A</span>
                        @endif
                    </div>
                    <div class="col-4 d-flex flex-column gap-2">
                        <span class="detail-label">Number of players:</span>
                        @if($product->players_max == null && $product->players_min != null)
                            <span class="detail-value">{{ $product->players_min }}+</span>
                        @elseif($product->players_max != null && $product->players_min != null)
                            <span class="detail-value">{{ $product->players_min }} to {{ $product->players_max }}</span>
                        @else
                            <span class="detail-value">N/A</span>
                        @endif
                    </div>
                </div>
            </div>

            <!--Purchase Section-->
            <form method="POST" action="/products/{{ $product->product_id }}/cart">
                @csrf
                <div class="d-flex align-items-center gap-5 gap-sm-5 mt-5">
                    <span class="product-price">{{ number_format($product->price, 2) }}€</span>

                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="quantity-value text-center" style="width: 50px; border: none;">
                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                    </div>

                    <button type="submit" class="add-to-cart btn-sm py-2 px-3">Add to Cart</button>
                </div>
            </form>
        </div>
    </div>

    <hr/>
    <!--Description Section-->
    <div class="row d-flex flex-column gap-3">
        <div class="col-12">
            <div class="d-flex flex-row gap-3 mb-3 p-2">
                <button onclick="location.href='#description'" class="btn btn-outline-secondary">Product Details</button>
                <button onclick="location.href='#reviews'" class="btn btn-outline-secondary">Reviews</button>
            </div>

            <!--Description Card-->
            <div class="detail-card w-100 d-block text-start mb-3 " id="description">
                <div class="description-content p-2">
                    <p class="description-heading">Game Description & Contents</p>
                    <p class="description-text">{!! nl2br(e($product->description)) !!}</p>

                    @if($product->gameplay)
                        <p class="description-heading">Gameplay</p>
                        <p class="description-text">{!! nl2br(e($product->gameplay)) !!}</p>
                    @endif

                    @if($product->contents)
                        <p class="description-heading">Game Content</p>
                        <p class="description-text">{{ $product->contents }}</p>
                    @endif
                </div>
            </div>

            <div class="row"><div class="col-12 col-md-8" id="reviews">
                    <!--Review Card-->
                    <div class="detail-card w-100 d-block text-start mb-3">
                        <div class="description-content p-3">
                            <p class="description-heading">Reviews</p>

                            <!--Single Review-->
                            <div class="mb-4">
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <h4>Reliable Customer</h4>
                                    </div>
                                    <div class="col-6 text-end">
                                        3.3.2026 &nbsp; ⭐⭐⭐⭐⭐
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>BANG! is, in my opinion, one of the best games I've ever played. It combines elements
                                                of classic card matching (strategy, what to use and on whom and what to keep in your hand)
                                                with the gradual revelation of the true intentions of your teammates. There are three groups,
                                                each with a different goal. The bandits want to kill...
                                                <a href="#" class="expandable-text">Show whole review</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Single Review-->
                            <div class="mb-4">
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <h4>Reliable Customer #2</h4>
                                    </div>
                                    <div class="col-6 text-end">
                                        1.2.2026 &nbsp; ⭐⭐⭐⭐
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>
                                                Once we start playing, we can't stop... more than once
                                                we've been shooting from evening to morning. Bank = guaranteed fun,
                                                ideal for 5 gunners ;)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto mx-auto">
                                    <button class="add-to-cart btn-sm py-2 px-3">Show all reviews</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Overview Card -->
                <div class="col-12 col-md-4">
                    <div class="detail-card text-start mb-3", style="padding: 20px !important;">
                        <div class="description-content p-2">
                            <p class="description-heading">Overview</p>

                            <!-- Average Score -->
                            <div class="text-center mb-3">
                                <h1 class="mb-0">4.6⭐</h1>
                                <p class="detail-label">out of 5 ⭐</p>
                                <p class="detail-label">76 reviews</p>
                            </div>

                            <!-- Star Bars -->
                            <div class="row align-items-center mb-1">
                                <div class="col-2 text-end">5 ⭐</div>
                                <div class="col-10">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 73%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-1">
                                <div class="col-2 text-end">4 ⭐</div>
                                <div class="col-10">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 18%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-1">
                                <div class="col-2 text-end">3 ⭐</div>
                                <div class="col-10">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 6%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-1">
                                <div class="col-2 text-end">2 ⭐</div>
                                <div class="col-10">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-1">
                                <div class="col-2 text-end">1 ⭐</div>
                                <div class="col-10">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 3%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto mx-auto mt-3">
                                    <button class="btn btn-outline-secondary">Write a review</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<!--Footer-->
<footer class="py-4 px-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <a href="/">
            <img src="/assets/kockac-logo-rec.png" alt="Kockáč" height="50">
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
    function changeQuantity(amount){
        const input = document.getElementById('quantity');
        const newVal = parseInt(input.value) + amount;
        if (newVal >= 1) input.value = newVal;
    }

    function changeMainImage(src, clicked) {
        document.getElementById('main-photo').src = src;

        const allThumbs = document.querySelectorAll('.secondary-photo');
        const index = Array.from(allThumbs).indexOf(clicked);
        const dots = document.querySelectorAll('.dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[index]) {
            dots[index].classList.add('active');
        }
    }

    function setActiveDot(clicked) {
        const dots = document.querySelectorAll('.dot');
        const index = Array.from(dots).indexOf(clicked);

        dots.forEach(dot => dot.classList.remove('active'));
        clicked.classList.add('active');

        const thumbs = document.querySelectorAll('.secondary-photo');
        if (thumbs[index]) {
            document.getElementById('main-photo').src = thumbs[index].src;
        }
    }
</script>
</body>
</html>
