@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/login.css">
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
@endsection

@section('modals')
    <!--Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <div class="fw-bold">Remove Product from Shopping Cart</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Remove</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container my-4">
        <h1 class="login-tittle text-center mb-4">Shopping Cart</h1>

        <div id="cart-items-section">
            @if($cart && $cart->items->count() > 0)
                @foreach($cart->items as $cartItem)
                    <div class="detail-card cart p-2 mb-2" id="cart-item-{{ $cartItem->cart_item_id }}">
                        <div class="row align-items-center mb-3">
                            <a href="/products/{{$cartItem->product->product_id}}" class="text-decoration-none text-dark col-6 d-flex align-items-center gap-2">
                                <div class="col-2">
                                    <img src="{{ $cartItem->product->images->where('is_main', true)->first()->image_path }}" alt="Product" class="img-fluid">
                                </div>
                                <div class="col-4 text-start">
                                    <p class="mb-0"><strong>{{$cartItem->product->name}}</strong></p>
                                    <p class="mb-0 text-muted">Available in stock</p>
                                    <p class="mb-0 mt-2"><strong>{{$cartItem->product->price}} €</strong></p>
                                </div>
                            </a>
                            <div class="col-3 d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="changeQuantity({{ $cartItem->cart_item_id }}, -1)">-</button>
                                    <span id="qty-{{ $cartItem->cart_item_id }}" class="px-2">{{ $cartItem->quantity }}</span>
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                            onclick="changeQuantity({{ $cartItem->cart_item_id }}, 1)">+</button>
                                </div>
                            </div>
                            <div class="col-3 text-center">
                                <button class="btn btn-nav rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-id="{{ $cartItem->cart_item_id }}">
                                    <img src="/assets/trash-icon.png" alt="Delete Item" height="30">
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="detail-card p-5 text-center">
                    <img src="/assets/icons/icon-trolley.png" alt="Empty Cart" height="80" class="mb-3 opacity-50">
                    <h3 class="mb-2">Your cart is empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any games yet!</p>
                    <button onclick="location.href='/'" class="login-button">Browse Games</button>
                </div>
            @endif
        </div>

        <hr>
        <small class="text-muted d-flex align-items-center gap-2 mb-3">
            <img src="/assets/info-icon.png" alt="Info Icon" height="20">
            The items in this shopping cart are not reserved.
        </small>

        <div class="row mt-3">
            <div class="col-12 col-md-6 mb-3 order-2 order-md-1 align-self-end">
                <button onclick="location.href='/'" class="back-button">Continue Shopping</button>
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2">
                <div class="detail-card p-3 ms-auto w-75">
                    <div class="d-flex justify-content-between mt-2">
                        <h4><strong>Subtotal:</strong></h4>
                        @php $total = 0 @endphp
                        @if($cart && $cart->items->count() > 0)
                            @foreach($cart->items as $cartItem)
                                @php $total += $cartItem->quantity * $cartItem->product->price @endphp
                            @endforeach
                        @endif
                        <h4><strong id="subtotal">{{ number_format($total, 2) }} €</strong></h4>
                    </div>
                    <hr/>
                    <button onclick="location.href='/checkout'" class="login-button">CHECKOUT</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function changeQuantity(itemId, amount) {
            const span = document.getElementById('qty-' + itemId);
            const currentQty = parseInt(span.textContent);
            const newQty = currentQty + amount;

            if (newQty < 1) return;

            fetch(`/cart/${itemId}/update`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQty })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        span.textContent = newQty;
                        document.getElementById('subtotal').textContent = data.total.toFixed(2) + ' €';
                    }
                });
        }

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            const itemId = btn.getAttribute('data-item-id');

            document.getElementById('confirmDelete').onclick = function () {
                fetch(`/cart/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('cart-item-' + itemId).remove();
                            document.getElementById('subtotal').textContent = data.total.toFixed(2) + ' €';
                            bootstrap.Modal.getInstance(deleteModal).hide();

                            const remainingItems = document.querySelectorAll('[id^="cart-item-"]');
                            if (remainingItems.length === 0) {
                                document.getElementById('cart-items-section').innerHTML = `
                            <div class="detail-card p-5 text-center">
                                <img src="/assets/icons/icon-trolley.png" alt="Empty Cart" height="80" class="mb-3 opacity-50">
                                <h3 class="mb-2">Your cart is empty</h3>
                                <p class="text-muted mb-4">Looks like you haven't added any games yet!</p>
                                <button onclick="location.href='/'" class="login-button">Browse Games</button>
                            </div>
                        `;
                            }
                        }
                    });
            };
        });
    </script>
@endsection
