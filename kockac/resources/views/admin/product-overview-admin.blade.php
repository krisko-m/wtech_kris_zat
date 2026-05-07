@extends('layouts.app')

@section('title', 'Admin Overview - Kockac')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/productoverview.css" />
    <link rel="stylesheet" type="text/css" href="/css/login.css" />
@endsection

@section('content')
    <!--Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <div class="fw-bold">Delete Product</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Main-->
    <main class="container-fluid px-4 my-4">
        <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
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
                        <span class="filter-label">Price</span>
                        <div class="d-flex gap-2 mb-2">
                            <input type="number" name="price_min" id="price_min" class="form-control filter-input"
                                   placeholder="€ 0" min="0" max="300" value="{{ request('price_min') }}">
                            <input type="number" name="price_max" id="price_max" class="form-control filter-input"
                                   placeholder="€ 300" min="0" max="300" value="{{ request('price_max') }}">
                        </div>
                        <input type="range" id="range_min" class="form-range" min="0" max="300" value="{{ request('price_min', 0) }}">
                        <input type="range" id="range_max" class="form-range" min="0" max="300" value="{{ request('price_max', 300) }}">
                    </div>

                    <!-- Number of Players -->
                    <div class="filter-section">
                        <div class="filter-label">Number of Players</div>
                        <input type="number" name="players" id="players_input" class="form-control filter-input text-center" placeholder="1"
                               value="{{request('players')}}" min="1">
                        <input type="range" id="players_range" class="form-range mt-2" min="1" max="20" value="{{ request('players', 1) }}">
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
                        <div class="col" style="position: relative">
                            <div class="card-actions">
                                <img src="/assets/trash-icon.png"
                                     alt="Delete Button"
                                     onclick="prepareDelete({{ $product->product_id }})">
                                <img onclick="location.href='{{route('admin.products.edit', $product->product_id)}}'"
                                     src="/assets/edit-icon.png"
                                     alt="Edit Icon">
                            </div>
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
@endsection

@section('scripts')
    <script>
        function setSort(value) {
            document.getElementById('sortInput').value = value;

            const pageInput = document.getElementById('pageInput');
            if (pageInput) pageInput.value = 1;

            document.getElementById('filterForm').submit();
        }

        const priceMin = document.getElementById('price_min');
        const rangeMin = document.getElementById('range_min');
        rangeMin.addEventListener('input', () => priceMin.value = rangeMin.value);
        priceMin.addEventListener('input', () => rangeMin.value = priceMin.value);

        // Price max
        const priceMax = document.getElementById('price_max');
        const rangeMax = document.getElementById('range_max');
        rangeMax.addEventListener('input', () => priceMax.value = rangeMax.value);
        priceMax.addEventListener('input', () => rangeMax.value = priceMax.value);

        // Players
        const playersInput = document.getElementById('players_input');
        const playersRange = document.getElementById('players_range');
        if (playersInput && playersRange) {
            playersRange.addEventListener('input', () => playersInput.value = playersRange.value);
            playersInput.addEventListener('input', () => playersRange.value = playersInput.value);
        }

        function prepareDelete(id) {
            const form = document.getElementById('deleteForm');
            form.action = '/admin/products/' + id;

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
@endsection
