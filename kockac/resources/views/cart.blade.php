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
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
</head>

<!--Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <div class="fw-bold">Remove Product from Shopping Cart</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to remove this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Remove</button>
            </div>
        </div>
    </div>
</div>

<body>
<!--Navbar-->
<nav class="top-navbar">
    <a href="/">
        <img src="/assets/kockac-logo-rec.png" alt="Kockáč" height="70">
    </a>

    <form class="search-wrap" role="search">
        <div class="input-group">
            <input type="text" class="form-control rounded-pill ps-4" placeholder="Search...">
            <button class="btn position-absolute end-0 top-50 translate-middle-y pe-3" type="submit" style="z-index: 5; background: transparent; border: none;">
                <img src="/assets/icon-search.png" alt="Search" height="18">
            </button>
        </div>
    </form>

    <div class="d-flex align-items-center justify-content-end gap-2">
        <button class="btn btn-nav rounded-pill" data-bs-toggle="modal" data-bs-target="#accountModal">
            <img src="/assets/icon-user.png" alt="User" height="40">
        </button>

        <div class="modal fade" id="accountModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <div class="fw-bold">Not Logged In</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-2">
                        <hr class="my-2">
                        <a href="/login" class="d-flex align-items-center gap-2 py-2 text-decoration-none" style="color: var(--accent);">
                            Log In
                        </a>
                        <hr class="my-2">
                        <a href="/adminlogin" class="d-flex align-items-center gap-2 py-2 text-decoration-none" style="color: var(--accent);">
                            Admin Log In
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <button onclick="location.href='shopping-cart.html'" class="btn btn-nav rounded-pill">
            <img src="/assets/icon-trolley.png" alt="Cart" height="40">
        </button>
    </div>
</nav>

<!--Categories-->
<div class="categories-bar d-flex justify-content-center">
    <a href="/productoverview" class="cat-item">All Games</a>

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

<!--Shopping Cart-->
<div class="container my-4">
    <h1 class="login-tittle text-center mb-4">Shopping Cart</h1>

    <!--Cart Item-->
    @if($cart && $cart->items->count() > 0)
        @foreach($cart->items as $cartItem)
        <div class="detail-card cart p-2 mb-2">
                <div class="row align-items-center mb-3">
                    <a href="/products/{{$cartItem->product->product_id}}" class="text-decoration-none text-dark col-6 d-flex align-items-center gap-2">
                        <!--Photo-->
                        <div class="col-2">
                            <img src="{{ $cartItem->product->images->where('is_main', true)->first()->image_path }}" alt="Product" class="img-fluid">
                        </div>
                        <!--Name & Price-->
                        <div class="col-4 text-start">
                            <p class="mb-0"><strong> {{$cartItem->product->name}} </strong></p>
                            <p class="mb-0 text-muted">Available in stock</p>
                            <p class="mb-0 mt-2"><strong>{{$cartItem->product->price}} €</strong></p>
                        </div>
                    </a>
                    <!--Quantity-->
                    <div class="col-3 d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-outline-secondary">-</button>
                            <span class="quantity-value">{{$cartItem->quantity}}</span>
                            <button class="btn btn-outline-secondary">+</button>
                        </div>
                    </div>
                    <!--Delete-->
                    <div class="col-3 text-center">
                        <button class="btn btn-nav rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <img src="/assets/trash-icon.png" alt="Delete Item" height="30">
                        </button>
                    </div>
                </div>
        </div>
        @endforeach
    @else
        <div class="detail-card p-5 text-center">
            <img src="/assets/icon-trolley.png" alt="Empty Cart" height="80" class="mb-3 opacity-50">
            <h3 class="mb-2">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added any games yet!</p>
            <button onclick="location.href='/'" class="login-button">Browse Games</button>
        </div>
    @endif

    <hr>
    <small class="text-muted d-flex align-items-center gap-2 mb-3">
        <img src="/assets/info-icon.png" alt="Info Icon" height="20">
        The items in this shopping cart are not reserved.
    </small>


    <div class="row mt-3">
        <!--Continue Shopping-->
        <div class="col-12 col-md-6 mb-3 order-2 order-md-1 align-self-end">
            <button onclick="location.href='/'" class="back-button">Continue Shopping</button>
        </div>

        <!--Checkout Card-->
        <div class="col-12 col-md-6 order-1 order-md-2">
            <div class="detail-card p-3 ms-auto w-75">
                <div class="d-flex justify-content-between mt-2">
                    <h4><strong>Subtotal:</strong></h4>
                    @php $total = 0 @endphp
                    @if($cart && $cart->items->count() > 0)
                        @foreach($cart->items as $cartItem)
                            @php $total += $cartItem->quantity * $cartItem->product->price @endphp
                        @endforeach
                    @else
                        @php $total = '0.00' @endphp
                    @endif
                    <h4><strong>{{ $total }} €</strong></h4>
                </div>
                <hr/>
                <button onclick="location.href='checkout-address.html'" class="login-button">CHECKOUT</button>
            </div>
        </div>
    </div>

</div>

<!--Footer-->
<footer class="py-4 px-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <a href="/">
            <img src="../assets/kockac-logo-rec.png" alt="Kockáč" height="50">
        </a>
        <div class="footer-links d-flex gap-4">
            <a href="#">Terms &amp; Conditions</a>
            <a href="#">Privacy Policy</a>
        </div>
        <div class="footer-copy">© 2026 Kockac.com · All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
