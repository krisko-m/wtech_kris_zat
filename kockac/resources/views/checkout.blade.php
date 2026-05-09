@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/login.css">
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
@endsection

@section('content')
    <div class="container my-4">

        <div class="text-center mt-4 mb-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="70">
            </a>
        </div>

        <form method="POST" action="/checkout">
            @csrf

            <!--Delivery Details Card-->
            <div class="login-container d-flex justify-content-center mt-3 mb-3">
                <div class="checkout-card">
                    <h2 class="login-title">Delivery Details</h2>

                    <div class="row gy-3 mb-3">
                        <div class="col-md-6">
                            <h5>First Name</h5>
                            <input name="first_name" type="text"
                                   class="form-control login-input w-100 @error('first_name') is-invalid @enderror"
                                   value="{{ old('first_name', $user->first_name ?? '') }}">
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <h5>Last Name</h5>
                            <input name="last_name" type="text"
                                   class="form-control login-input w-100 @error('last_name') is-invalid @enderror"
                                   value="{{ old('last_name', $user->last_name ?? '') }}">
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <div class="col-md-6">
                            <h5>Address</h5>
                            <input name="address" type="text"
                                   class="form-control login-input w-100 @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <h5>Additional Details</h5>
                            <input name="additional_details" type="text"
                                   class="form-control login-input w-100"
                                   value="{{ old('additional_details') }}">
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <div class="col-md-6">
                            <h5>Postal Code</h5>
                            <input name="postal_code" type="text"
                                   class="form-control login-input w-100 @error('postal_code') is-invalid @enderror"
                                   value="{{ old('postal_code') }}">
                            @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <h5>City</h5>
                            <input name="city" type="text"
                                   class="form-control login-input w-100 @error('city') is-invalid @enderror"
                                   value="{{ old('city') }}">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <div class="col-md-6">
                            <h5>Country</h5>
                            <input name="country" type="text"
                                   class="form-control login-input w-100 @error('country') is-invalid @enderror"
                                   value="{{ old('country', 'Slovakia') }}">
                            @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <h5>E-Mail</h5>
                            <input name="email" type="email"
                                   class="form-control login-input w-100 @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email ?? '') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!--Transport Card-->
            <div class="login-container d-flex justify-content-center mb-3">
                <div class="checkout-card">
                    <h2 class="login-title">Mode of Transport</h2>
                    @error('delivery_method_id')
                    <div class="alert alert-danger py-1 mb-2">{{ $message }}</div>
                    @enderror
                    @foreach($deliveryMethods as $method)
                        <div class="form-check mb-2">
                            <div class="d-flex flex-row align-items-center justify-content-between">
                                <div class="d-flex gap-2 align-items-center">
                                    <input class="form-check-input" type="radio"
                                           name="delivery_method_id"
                                           id="delivery_{{ $method->delivery_method_id }}"
                                           value="{{ $method->delivery_method_id }}"
                                        {{ old('delivery_method_id') == $method->delivery_method_id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="delivery_{{ $method->delivery_method_id }}">
                                        {{ $method->name }}
                                    </label>
                                </div>
                                <h6 class="mb-0"><strong>3,99 €</strong></h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!--Payment Card-->
            <div class="login-container d-flex justify-content-center mb-3">
                <div class="checkout-card">
                    <h2 class="login-title">Payment Method</h2>
                    @error('payment_method_id')
                    <div class="alert alert-danger py-1 mb-2">{{ $message }}</div>
                    @enderror
                    @foreach($paymentMethods as $method)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio"
                                   name="payment_method_id"
                                   id="payment_{{ $method->payment_method_id }}"
                                   value="{{ $method->payment_method_id }}"
                                {{ old('payment_method_id') == $method->payment_method_id ? 'checked' : '' }}>
                            <label class="form-check-label" for="payment_{{ $method->payment_method_id }}">
                                {{ $method->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Buttons -->
            <div class="row mt-3">
                <div class="col-12 col-md-6 mb-3 order-2 order-md-1 align-self-end">
                    <button type="button" onclick="location.href='/cart'" class="back-button">Back to Cart</button>
                </div>
                <div class="col-12 col-md-6 order-1 order-md-2">
                    <div class="detail-card p-3 ms-auto w-75">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>{{ number_format($subtotal, 2) }} €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Delivery:</span>
                            <span>3,99 €</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h4><strong>Total:</strong></h4>
                            <h4><strong>{{ number_format($subtotal + 3.99, 2) }} €</strong></h4>
                        </div>
                        <button type="submit" class="login-button">Confirm Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
