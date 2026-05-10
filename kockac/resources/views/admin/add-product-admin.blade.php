@extends('layouts.app')

@section('title', 'Add Product - Kockac')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
@endsection

@section('modals')
    @include('modals.image-library')
@endsection

@section('content')
    <main class="container my-5">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <!--Product Section-->
            <div class="d-flex flex-md-row flex-column product-container justify-center">
                <!--Photos-->
                <div class="col-md-5 d-flex flex-md-row flex-column align-items-center mb-4 gap-1">
                    <div class="d-flex flex-md-column flex-sm-row align-items-center mb-md-3 gap-3">
                        @foreach([1, 2, 3] as $i)
                            <div class="image-slot secondary-slot position-relative" style="cursor:pointer">
                                <img id="preview-{{ $i }}"
                                     src="{{ asset('assets/icons/add-secondary-photo.png') }}"
                                     alt="Add-image"
                                     class="editable-photo secondary-photo img-fluid mb-3"
                                     onclick="openImageModal({{ $i }}, false)">

                                <input type="hidden" name="image_ids[]" id="image-id-{{ $i }}" value="">

                                <button type="button" id="detach-{{ $i }}"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1 d-none"
                                        onclick="detachImage({{ $i }}, '{{ asset('assets/icons/add-secondary-photo.png') }}')">×</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex flex-column mb-3 align-items-center">
                        <div class="image-slot main-slot position-relative main-photo-container">
                            <img id="preview-0"
                                 src="/assets/main-photo-icon.png"
                                 class="editable-photo main-photo ms-5"
                                 onclick="openImageModal(0, true)">

                            <input type="hidden" name="main_image_id" id="image-id-0" value="">

                            <button type="button" id="detach-0"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1 d-none"
                                    onclick="detachImage(0, '/assets/main-photo-icon.png')">×</button>
                        </div>
                    </div>
                </div>

                <!--Product Info-->
                <div class="col-md-7 product-info d-flex flex-column gap-3 mb-4">
                    <!--Product Name & Author-->
                    <div class="row w-120 mb-3">
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="name" id="product-name" class="form-control login-input w-75" placeholder="Name" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="author" id="product-author" class="form-control login-input w-75" placeholder="Author" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="publisher" id="product-publisher" class="form-control login-input w-75" placeholder="Publisher" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                    </div>


                    <!--Details Card-->
                    <div class="my-3 d-flex flex-md-row flex-column justify-content-evenly detail-card">
                        <!--Recommended Age-->
                        <div class="col-4 d-flex flex-column text-start">
                            <span class="detail-label">Recommended age:</span>
                            <input type="text" name="recommended_age" id="detail-age"
                                       class="form-control login-input w-50 mt-2" placeholder="Age">
                        </div>
                        <!-- Min & Max Duration-->
                        <div class="d-flex flex-column text-start">
                            <span class="detail-label">Duration of a game:</span>
                            <div class="d-flex flex-row">
                                <input type="text" name="duration_min" id="detail-duration"
                                       class="form-control login-input w-25 mt-2" placeholder="Min.">
                                <span class="detail-label"> - </span>
                                <input type="text" name="duration_max" id="detail-duration"
                                       class="form-control login-input w-25 mt-2" placeholder="Max.">
                            </div>
                        </div>
                        <!--Min & Max Number of Players-->
                        <div class="d-flex flex-column text-start">
                            <span class="detail-label">Number of players:</span>
                            <div class="d-flex flex-row">
                                <input type="text" name="players_min" id="detail-players"
                                       class="form-control login-input w-25 mt-2" placeholder="Min.">
                                <span class="detail-label"> - </span>
                                <input type="text" name="players_max" id="detail-players"
                                       class="form-control login-input w-25 mt-2" placeholder="Max.">
                            </div>
                        </div>
                    </div>

                    <!--Purchase Section-->
                    <div class="row w-120 mb-3">
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="price" id="detail-price" class="form-control login-input w-md-50 w-sm-75" placeholder="Price" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="stock_quantity" id="detail-stock" class="form-control login-input w-md-50 w-sm-75" placeholder="Quantity" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <!--Description Section-->
            <div class="row d-flex flex-column gap-3">
                <div class="col-12">
                    <!--Description Card-->
                    <div class="detail-card w-100 d-block text-start mb-3">
                        <h1>Game Description & Contents</h1>
                        <!--Game Complexity & Genre-->
                        <div class="d-flex gap-3 mb-3 p-2">
                            <div class="col-6 col-md-2">
                                <label for="complexity" class="description-heading mb-2">Complexity</label>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="cat-item dropdown-toggle text-center d-block" data-bs-toggle="dropdown">Select complexity</a>
                                    <ul class="dropdown-menu" style="min-width: 100%;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectComplexity('beginner', this)">Beginner</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectComplexity('gateway', this)">Gateway</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectComplexity('intermediate', this)">Intermediate</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectComplexity('expert', this)">Expert</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="selectComplexity('hardcore', this)">Hardcore</a></li>
                                    </ul>
                                    <input type="hidden" name="complexity" id="complexity-value">
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="description-heading mb-2">Genre</label>
                                <div class="d-flex flex-column gap-1">
                                    @foreach(['Family', 'Puzzle', 'Card Games', 'Strategic', 'Party'] as $g)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="genres[]"
                                                   id="genre_add_{{ $g }}"
                                                   value="{{ $g }}">
                                            <label class="form-check-label" for="genre_add_{{ $g }}">{{ $g }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!--Game Description-->
                        <div class="description-content p-2">
                            <div class="d-flex flex-row">
                                <h2 class="description-heading me-3">Game Description</h2>
                                <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                            </div>
                            <textarea rows="4" name="description" id="description-game" class="form-control login-input w-100" placeholder="Add a Game Description..." required></textarea>

                            <!--Gameplay Description-->
                            <div class="d-flex flex-row">
                                <h2 class="description-heading me-3">Gameplay</h2>
                                <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                            </div>
                            <textarea rows="4" name="gameplay" id="description-gameplay" class="form-control login-input w-100" placeholder="Add a description of Gameplay..."></textarea>

                            <!--Game Content Description-->
                            <div class="d-flex flex-row">
                                <h2 class="description-heading me-3">Game Content</h2>
                                <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                            </div>
                            <textarea rows="4" name="contents" id="description-content" class="form-control login-input w-100" placeholder="Add the Game Contents..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!--Save & Discard Button-->
            <div class="d-flex flex-row justify-content-end">
                <a href="{{ url('/admin/products') }}" class="btn btn-outline-secondary me-2">Discard Product</a>
                <button type="submit" class="add-to-cart btn-sm py-2 px-3 ms-2">Save Product</button>
            </div>
        </form>
    </main>
@endsection

@section('scripts')
    <script>
        function selectComplexity(value, el) {
            document.getElementById('complexity-value').value = value;
            el.closest('.dropdown').querySelector('.dropdown-toggle').textContent = el.textContent;
        }
    </script>
    <script src="{{ asset('js/product-image-manager.js') }}"></script>
    <script>
        function triggerUpload() {
            uploadImage('{{ csrf_token() }}');
        }

        function triggerDelete(id) {
            deleteImage(id, '{{ csrf_token() }}');
        }
    </script>
    <script>
        // Load the Image Grid
        async function loadImages() {
            let grid= document.getElementById('image-grid');
            grid.innerHTML = '';

            let response = await fetch('/admin/images?product_id=&unused=1');
            let images = await response.json();

            // In case there are no images
            if (images.length === 0){
                grid.innerHTML = '<p class="text-muted">No images found.</p>';
                return
            }

            for (let i = 0; i < images.length; i++) {
                let image = images[i];

                grid.innerHTML += `
                    <div class="col-6 col-md-3">
                        <div class="detail-card p-2 text-center">
                            <img src="${image.image_path}" class="img-fluid mb-2" style="height:120px; object-fit:contain; cursor:pointer"
                            onclick="selectImage(${image.image_id}, '${image.image_path}')">
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectImage(${image.image_id}, '${image.image_path}')">
                                Select
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteImage(${image.image_id}, this)">
                                Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }

        }
    </script>
@endsection
