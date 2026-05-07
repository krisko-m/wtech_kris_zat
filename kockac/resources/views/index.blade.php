@extends('layouts.app')

@section('title', 'Kockac')

@section('content')

    <!--Banner-->
    <div class="container-fluid px-4">
        <div class="banner d-flex flex-column justify-content-center">
            <h2>New Additions to your Collection!!!<br><span>Summer 2026</span></h2>
            <p class="mb-0">Discover the latest additions to our store. Less money, more fun.</p>
        </div>
    </div>

    <!--Products-->
    <div class="container-fluid px-4 mt-4">
        <div class="d-flex align-items-baseline justify-content-between mb-3">
            <div class="section-title">NEW / HOT Products</div>
            <a href="{{ url('/products') }}" class="see-all">Show all →</a>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5 g-3 pb-5">
            <div class="col">
                <a href="{{ url('/products/1') }}" class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/products/Bang/product-bang-1.png') }}" alt="Bang">
                        <div class="product-badge">NEW</div>
                    </div>
                    <div class="p-3">
                        <div class="product-name mb-1">Bang!</div>
                        <div class="product-price">15,99 €</div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="#" class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/product-catan.png') }}" alt="Catan">
                        <div class="product-badge">HOT</div>
                    </div>
                    <div class="p-3">
                        <div class="product-name mb-1">Catan - Base Game</div>
                        <div class="product-price">44,99 €</div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="#" class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/product-hitster.png') }}" alt="Hitster">
                        <div class="product-badge">HOT</div>
                    </div>
                    <div class="p-3">
                        <div class="product-name mb-1">Hitster - The Music Party Game</div>
                        <div class="product-price">24,99 €</div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="#" class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/product-uno.png') }}" alt="Uno">
                        <div class="product-badge">NEW</div>
                    </div>
                    <div class="p-3">
                        <div class="product-name mb-1">UNO</div>
                        <div class="product-price">9,99 €</div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="#" class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/product-witcherow.png') }}" alt="WitcherOW">
                        <div class="product-badge">NEW</div>
                    </div>
                    <div class="p-3">
                        <div class="product-name mb-1">The Witcher - Old World</div>
                        <div class="product-price">79,99 €</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection
