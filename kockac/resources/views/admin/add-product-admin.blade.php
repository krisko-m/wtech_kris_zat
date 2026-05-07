@extends('layouts.app')

@section('title', 'Add Product - Kockac')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
@endsection

@section('content')
    <main class="container my-5">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <!--Product Section-->
            <div class="d-flex flex-row product-container">
                <!--Photos-->
                <div class="col-md-5 d-flex flex-row align-items-center mb-4 gap-1">
                    <div class="d-flex flex-column align-items-center mb-3">
                        <img src="/assets/add-circle-icon.png" alt="Product photo" class="editable-photo img-fluid mb-3" style="max-width: 50px; height: auto">
                        <img src="/assets/add-circle-icon.png" alt="Product photo" class="editable-photo img-fluid mb-3" style="max-width: 50px; height: auto">
                        <img src="/assets/add-circle-icon.png" alt="Product photo" class="editable-photo img-fluid mb-3" style="max-width: 50px; height: auto">
                    </div>
                    <div class="d-flex flex-column mb-3 align-items-center">
                        <img src="/assets/main-photo-icon.png" alt="Main product photo" class="editable-photo ms-5" style="max-width: 300px; height: auto">
                        <div class="d-flex flex-row gap-2 mt-4">
                            <button class="dot active"></button>
                            <button class="dot"></button>
                            <button class="dot"></button>
                            <button class="dot"></button>
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
                    <div class="my-3 d-flex flex-row justify-content-evenly detail-card">
                        <!--Recommended Age-->
                        <div class="col-4 d-flex flex-column text-start">
                            <span class="detail-label">Recommended age:</span>
                            <input type="text" name="recommended_age" id="detail-age"
                                       class="form-control login-input w-50 mt-2" placeholder="Age">
                        </div>
                        <!-- Min & Max Duration-->
                        <div class="col-4 d-flex flex-column text-start">
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
                        <div class="col-4 d-flex flex-column text-start">
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
                            <input type="text" name="price" id="detail-price" class="form-control login-input w-50" placeholder="Price" required>
                            <img src="/assets/edit-icon.png" alt="Edit Icon" class="img-fluid edit-icon">
                        </div>
                        <div class="col-4 d-flex flex-row gap-2">
                            <input type="text" name="stock_quantity" id="detail-stock" class="form-control login-input w-50" placeholder="Quantity" required>
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
                        <!--Game Complexity-->
                        <div class="mb-3 p-2">
                            <label for="complexity" class="description-heading mb-2">Complexity</label>
                            <select id="complexity" name="complexity" class="form-select w-25" required>
                                <option value="">Select complexity</option>
                                <option value="beginner">Beginner</option>
                                <option value="gateway">Gateway</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="expert">Expert</option>
                                <option value="hardcore">Hardcore</option>
                            </select>
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
                <button class="btn btn-outline-secondary me-2">Discard Product</button>
                <button type="submit" class="add-to-cart btn-sm py-2 px-3 ms-2">Save Product</button>
            </div>
        </form>
    </main>
@endsection
