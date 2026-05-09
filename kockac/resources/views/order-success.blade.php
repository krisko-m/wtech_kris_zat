@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/login.css">
@endsection

@section('content')
    <div class="container my-4 text-center">
        <div class="mt-5">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="70">
            </a>
        </div>

        <div class="detail-card p-5 mt-4 d-inline-block">
            <h1 class="mb-3">🎉 Order Confirmed!</h1>
            <p class="text-muted mb-1">Your order #{{ session('order_id') }} has been placed successfully.</p>
            <p class="text-muted mb-4">You will receive a confirmation email shortly.</p>
            <button onclick="location.href='/'" class="login-button">Continue Shopping</button>
        </div>
    </div>
@endsection
