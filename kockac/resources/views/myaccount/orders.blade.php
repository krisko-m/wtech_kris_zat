@extends('layouts.app')

@section('title', 'My Orders')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/myaccount.css">
@endsection

@section('content')
    <main class="container my-5">
        <div class="row gap-4">

            @include('myaccount.sidebar')

            <div class="col">
                <h2 class="account-heading mb-4">Orders</h2>

                <div class="account-card">
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                            <div class="order-card cart p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Order #{{ $order->order_id }}</strong>
                                    <span class="badge bg-secondary">{{ $order->status->status ?? 'pending' }}</span>
                                    <span class="text-muted" style="font-size: 0.85rem;">{{ $order->created_at }}</span>
                                    <strong>{{ number_format($order->total_price, 2) }} €</strong>
                                </div>
                                <hr class="my-2">
                                @foreach($order->items as $item)
                                    <div class="row align-items-center mb-2">
                                        <div class="col-2">
                                            @if($item->product->images->where('is_main', true)->first())
                                                <img src="{{ $item->product->images->where('is_main', true)->first()->image_path }}"
                                                     alt="{{ $item->product->name }}" class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-0"><strong>{{ $item->product->name }}</strong></p>
                                            <p class="mb-0 text-muted">Quantity: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="col-4 text-end">
                                            <p class="mb-0">{{ number_format($item->price_at_purchase, 2) }} €</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">You have no orders yet.</p>
                            <button onclick="location.href='/products'" class="btn account-save-btn">Browse Games</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
