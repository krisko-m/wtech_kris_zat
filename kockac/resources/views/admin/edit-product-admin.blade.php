@extends('layouts.app')

@section('title', 'Edit Product - Kockac')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
@endsection

@section('content')
    <main class="container my-5">
        <form method="POST" action="/admin/products/{{ $product->product_id }}" >
            @csrf
            @method('PUT')
            <input type="hidden" id="product-id" value="{{ $product->product_id }}">
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
                            @php
                                $secondaryImage = $product->images->where('is_main', false)->values()->get($i - 1);
                            @endphp

                            <div class="image-slot secondary-slot position-relative" style="cursor:pointer">
                                <img id="preview-{{ $i }}"
                                     src="{{ $secondaryImage ? $secondaryImage->image_path : '/assets/add-circle-icon.png' }}"
                                     alt="Product photo"
                                     class="editable-photo img-fluid mb-3"
                                     style="max-width: 50px; height: auto"
                                     onclick="openImageModal({{ $i }}, false)">

                                <input type="hidden" name="image_ids[]" id="image-id-{{ $i }}"
                                       value="{{ $secondaryImage ? $secondaryImage->image_id : '' }}">

                                <button type="button"
                                        id="detach-{{ $i }}"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1 {{ $secondaryImage ? '' : 'd-none' }}"
                                        onclick="detachImage({{ $i }}, '/assets/add-circle-icon.png')">×</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex flex-column mb-3 align-items-center">
                        @php
                            $mainImage = $product->images->where('is_main', true)->first();
                        @endphp

                        <div class="image-slot main-slot position-relative" style="cursor:pointer">
                            <img id="preview-0"
                                 src="{{ $mainImage ? $mainImage->image_path : '/assets/main-photo-icon.png' }}"
                                 alt="Main product photo"
                                 class="editable-photo ms-5"
                                 style="max-width: 300px; height: auto"
                                 onclick="openImageModal(0, true)">

                            <input type="hidden" name="main_image_id" id="image-id-0"
                                   value="{{ $mainImage ? $mainImage->image_id : '' }}">

                            <button type="button"
                                    id="detach-0"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1 {{ $mainImage ? '' : 'd-none' }}"
                                    onclick="detachImage(0, '/assets/main-photo-icon.png')">×</button>
                        </div>

                        <div class="d-flex flex-row gap-2 mt-4">
                            <button type="button" class="dot active"></button>
                            <button type="button" class="dot"></button>
                            <button type="button" class="dot"></button>
                            <button type="button" class="dot"></button>
                        </div>
                    </div>
                </div>

                <!--Product Info-->
                <div class="col-md-7 product-info d-flex flex-column gap-3 mb-4">
                    <!--Product Name & Author-->
                    <div class="row w-120 mb-3">
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="name" id="product-name"
                                   value="{{ old('name', $product->name ?? '') }}"
                                   class="form-control login-input w-75" placeholder="Name" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="author" id="product-author"
                                   value="{{ old('author', $product->author ?? '') }}"
                                   class="form-control login-input w-75" placeholder="Author" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="publisher" id="product-publisher"
                                   value="{{ old('publisher', $product->publisher ?? '') }}"
                                   class="form-control login-input w-75" placeholder="Publisher" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                    </div>

                    <!--Details Card-->
                    <div class="my-3 d-flex flex-md-row flex-column justify-content-evenly detail-card">
                        <div class="col-4 d-flex flex-column text-start">
                            <span class="detail-label">Recommended age:</span>
                            <input type="text" name="recommended_age" id="detail-age"
                                   value="{{ old('recommended_age', $product->recommended_age) }}"
                                   class="form-control login-input w-50 mt-2" placeholder="Age">
                        </div>
                        <div class="d-flex flex-column text-start">
                            <span class="detail-label">Duration of a game:</span>
                            <div class="d-flex flex-row">
                                <input type="text" name="duration_min" id="detail-duration"
                                       value="{{ old('duration_min', $product->duration_min) }}"
                                       class="form-control login-input w-25 mt-2" placeholder="Min.">
                                <span class="detail-label"> - </span>
                                <input type="text" name="duration_max" id="detail-duration"
                                       value="{{ old('duration_max', $product->duration_max) }}"
                                       class="form-control login-input w-25 mt-2" placeholder="Max.">
                            </div>
                        </div>
                        <div class="d-flex flex-column text-start">
                            <span class="detail-label">Number of players:</span>
                            <div class="d-flex flex-row">
                                <input type="text" name="players_min" id="detail-players"
                                       value="{{ old('players_min', $product->players_min) }}"
                                       class="form-control login-input w-25 mt-2" placeholder="Min.">
                                <span class="detail-label"> - </span>
                                <input type="text" name="players_max" id="detail-players"
                                       value="{{ old('players_max', $product->players_max) }}"
                                       class="form-control login-input w-25 mt-2" placeholder="Max.">
                            </div>
                        </div>
                    </div>

                    <!--Purchase Section-->
                    <div class="row w-120 mb-3">
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="price" id="detail-price"
                                   value="{{ old('price', $product->price) }}"
                                   class="form-control login-input w-50" placeholder="Price" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="stock_quantity" id="detail-stock"
                                   value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                   class="form-control login-input w-50" placeholder="Quantity" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <!--Description Section-->
            <div class="row d-flex flex-column gap-3">
                <div class="col-12">
                    <div class="detail-card w-100 d-block text-start mb-3">
                        <h1>Game Description & Contents</h1>

                        <!--Game Complexity & Genre-->
                        <div class="d-flex gap-3 mb-3 p-2">
                            <div class="col-6 col-md-2">
                                <label for="complexity" class="description-heading mb-2">Complexity</label>
                                <div class="col-12">
                                    <select id="complexity" name="complexity" class="form-select w-md-25 w-sm-50" required>
                                        <option value="beginner" {{ old('complexity', $product->complexity) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="gateway" {{ old('complexity', $product->complexity) == 'gateway' ? 'selected' : '' }}>Gateway</option>
                                        <option value="intermediate" {{ old('complexity', $product->complexity) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="expert" {{ old('complexity', $product->complexity) == 'expert' ? 'selected' : '' }}>Expert</option>
                                        <option value="hardcore" {{ old('complexity', $product->complexity) == 'hardcore' ? 'selected' : '' }}>Hardcore</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <label class="description-heading mb-2">Genre</label>
                                <div class="d-flex flex-column gap-1">
                                    @php
                                        $currentGenres = old('genres', $product->genres->pluck('genre_type')->toArray());
                                    @endphp
                                    @foreach(['Family', 'Puzzle', 'Card Games', 'Strategic', 'Party'] as $g)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="genres[]"
                                                   id="genre_edit_{{ $g }}"
                                                   value="{{ $g }}"
                                                {{ in_array($g, $currentGenres) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genre_edit_{{ $g }}">{{ $g }}</label>
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
                            <textarea rows="4" name="description" id="description-game"
                                      class="form-control login-input w-100"
                                      placeholder="Add a Game Description..." required>{{ old('description', $product->description ?? '') }}</textarea>

                            <div class="d-flex flex-row">
                                <h2 class="description-heading me-3">Gameplay</h2>
                                <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                            </div>
                            <textarea rows="5" name="gameplay" id="description-gameplay"
                                      class="form-control login-input w-100"
                                      placeholder="Add a description of Gameplay...">{{ old('gameplay', $product->gameplay ?? '') }}</textarea>

                            <div class="d-flex flex-row">
                                <h2 class="description-heading me-3">Game Content</h2>
                                <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                            </div>
                            <textarea rows="4" name="contents" id="description-content"
                                      class="form-control login-input w-100"
                                      placeholder="Add the Game Contents...">{{ old('contents', $product->contents ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!--Save & Discard Button-->
            <div class="d-flex flex-row justify-content-end mb-5">
                <a href="{{ url('/admin/products') }}" class="btn btn-outline-secondary me-2">Discard Changes</a>
                <button type="submit" class="add-to-cart btn-sm py-2 px-3 ms-2">Save Product</button>
            </div>
        </form>
    </main>

    <!-- Image Library Modal -->
    <div class="modal fade" id="imageLibraryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image Library</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-body">
                            <label class="fw-bold mb-2">Upload New Image</label>
                            <div class="d-flex gap-2">
                                <input type="file" id="upload-input" class="form-control" accept="image/*">
                                <button type="button" class="btn btn-secondary" onclick="uploadImage()">Upload</button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="loadImages()">Refresh List</button>
                    </div>

                    <!-- Image Grid -->
                    <div id="image-grid" class="row g-3">
                        <div class="text-center p-5">
                            <div class="spinner-border text-secondary" role="status"></div>
                            <p class="mt-2 text-muted">Loading library...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
        async function loadImages() {
            let productId = document.getElementById('product-id').value;
            let response = await fetch('/admin/images?product_id=' + productId);
            let images = await response.json();
            let grid = document.getElementById('image-grid');
            grid.innerHTML = '';

            if (images.length === 0) {
                grid.innerHTML = '<p class="text-muted">No images found.</p>';
                return;
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
