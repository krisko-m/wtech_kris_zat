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
            @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ url('/admin/products?sort=newest') }}" class="see-all">Show all →</a>
            @else
                <a href="{{ url('/products?sort=newest') }}" class="see-all">Show all →</a>
            @endif
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5 g-3 pb-5">

            {{-- NEW produkty --}}
            @foreach($newProducts as $product)
                <div class="col">
                    <a href="{{ url('/products/' . $product->product_id) }}" class="product-card">
                        <div class="product-img">
                            @if($product->mainImage)
                                <img src="{{ $product->mainImage->image_path }}" alt="{{ $product->name }}">
                            @endif
                            <div class="product-badge">NEW</div>
                        </div>
                        <div class="p-3">
                            <div class="product-name mb-1">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->price, 2) }} €</div>
                        </div>
                    </a>
                </div>
            @endforeach

            {{-- HOT produkty --}}
            @foreach($hotProducts as $product)
                <div class="col">
                    <a href="{{ url('/products/' . $product->product_id) }}" class="product-card">
                        <div class="product-img">
                            @if($product->mainImage)
                                <img src="{{ $product->mainImage->image_path }}" alt="{{ $product->name }}">
                            @endif
                            <div class="product-badge hot">HOT</div>
                        </div>
                        <div class="p-3">
                            <div class="product-name mb-1">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->price, 2) }} €</div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>

@endsection
