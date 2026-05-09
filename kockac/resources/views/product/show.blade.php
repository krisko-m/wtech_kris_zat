@extends('layouts.app')

@section('title')
    {{ $product->name }} - Kockac
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
@endsection

@section('content')
    <main class="container my-5">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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
                <div class="d-flex align-items-baseline gap-2">
                    <h1 class="product-name align-items-left mb-0">{{ $product->name }}</h1>
                    <span style="font-size: 0.9rem; color: gray;">· {{ $product->author }} · {{ $product->publisher }}</span>
                </div>
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

                <div class="detail-card w-100 d-block text-start mb-3" id="description">
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

                <!-- Reviews -->
                <div class="row">
                    <div class="col-12 col-md-8" id="reviews">
                        <div class="detail-card w-100 d-block text-start mb-3">
                            <div class="description-content p-3">
                                <p class="description-heading">Reviews</p>

                                @if($product->reviews->count() > 0)
                                    @foreach($product->reviews->take(2) as $review)
                                        <div class="mb-4">
                                            <div class="row mb-1">
                                                <div class="col-6">
                                                    <h4>{{ $review->user->first_name }} {{ $review->user->last_name }}</h4>
                                                </div>
                                                <div class="col-6 text-end">
                                                    {{ $review->created_at ? $review->created_at->format('d.m.Y') : '' }}
                                                    @for($i = 1; $i <= 5; $i++)
                                                        {{ $i <= $review->stars ? '⭐' : '' }}
                                                    @endfor
                                                </div>
                                                <div class="col-12">
                                                    <p>{{ $review->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @else
                                    <p class="text-muted">No reviews yet. Be the first to review!</p>
                                @endif

                                <div class="row">
                                    <div class="col-auto mx-auto">
                                        <button class="add-to-cart btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#allReviewsModal">Show all reviews</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Review Overview-->
                    <div class="col-12 col-md-4">
                        <div class="detail-card text-start mb-3" style="padding: 20px !important;">
                            <div class="description-content p-2">
                                <p class="description-heading">Overview</p>
                                <div class="text-center mb-3">
                                    <h1 class="mb-0">{{ number_format($product->reviews->avg('stars'), 1) }}⭐</h1>
                                    <p class="detail-label">out of 5 ⭐</p>
                                    <p class="detail-label">{{ $product->reviews->count() }} reviews</p>
                                </div>
                                @for($i = 5; $i >= 1; $i--)
                                    @php
                                        $count = $product->reviews->where('stars', $i)->count();
                                        $percentage = $product->reviews->count() > 0 ? ($count / $product->reviews->count())*100 : 0;
                                    @endphp
                                    <div class="row align-items-center mb-1">
                                        <div class="col-2 text-end">{{ $i }} ⭐</div>
                                        <div class="col-10">
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" style="width: {{ $percentage }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                                <!-- Write a review Button-->
                                <div class="row">
                                    <div class="col-auto mx-auto mt-3">
                                        @auth
                                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a review</button>
                                        @else
                                            <a href="{{route('login')}}" class="btn btn-outline-secondary">Log in to write a review</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="/products/{{ $product->product_id }}/reviews">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="dropdown">
                                <a href="javascript:void(0)" class="cat-item dropdown-toggle text-center d-block" data-bs-toggle="dropdown">⭐⭐⭐⭐⭐</a>
                                <ul class="dropdown-menu" style="min-width: 100%;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(5, this)">⭐⭐⭐⭐⭐</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(4, this)">⭐⭐⭐⭐</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(3, this)">⭐⭐⭐</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(2, this)">⭐⭐</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectStars(1, this)">⭐</a></li>
                                </ul>
                                <input type="hidden" name="stars" id="stars-value" value="5">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Your Review</label>
                            <textarea name="message" class="form-control login-input" rows="4" placeholder="Write your review here...">{{ old('message') }}</textarea>
                            @error('message')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="add-to-cart btn-sm py-2 px-3">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- All Reviews Modal -->
    <div class="modal fade" id="allReviewsModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="description-heading">All Reviews - {{ $product->name }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($product->reviews->count() > 0)
                        @foreach($product->reviews as $review)
                            <div class="mb-4">
                                <div class="row mb-1">
                                    <div class="col-6">
                                        <h5>{{ $review->user->first_name }} {{ $review->user->last_name }}</h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{ $review->created_at ? $review->created_at->format('d.m.Y') : '' }}
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= $review->stars ? '⭐' : '' }}
                                        @endfor
                                    </div>
                                    @if($review->message)
                                        <div class="col-12">
                                            <p>{{ $review->message }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <p class="text-muted">No reviews yet.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function selectStars(value, el) {
            document.getElementById('stars-value').value = value;
            el.closest('.dropdown').querySelector('.dropdown-toggle').textContent = el.textContent;
        }
    </script>
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
            if (dots[index]) dots[index].classList.add('active');
        }

        function setActiveDot(clicked) {
            const dots = document.querySelectorAll('.dot');
            const index = Array.from(dots).indexOf(clicked);
            dots.forEach(dot => dot.classList.remove('active'));
            clicked.classList.add('active');
            const thumbs = document.querySelectorAll('.secondary-photo');
            if (thumbs[index]) document.getElementById('main-photo').src = thumbs[index].src;
        }
    </script>
@endsection
