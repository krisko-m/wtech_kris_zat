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
                                   value="{{ old('address', $user->address ?? '') }}">
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
                                   value="{{ old('postal_code', $user->city->postal_code ?? '') }}">
                            @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <h5>City</h5>
                            <input name="city" type="text"
                                   class="form-control login-input w-100 @error('city') is-invalid @enderror"
                                   value="{{ old('city', $user->city->city ?? '') }}">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row gy-3 mb-3">
                        <div class="col-md-6">
                            <h5>Country</h5>
                            <input name="country" type="text"
                                   class="form-control login-input w-100 @error('country') is-invalid @enderror"
                                   value="{{ old('country', $user->city->country ?? 'Slovakia') }}">
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
                        <div class="mb-2">
                            <div class="d-flex flex-row align-items-center justify-content-between">
                                <div class="d-flex gap-2 align-items-center">
                                    <input class="form-check-input" type="radio"
                                           name="delivery_method_id"
                                           id="delivery_{{ $method->delivery_method_id }}"
                                           value="{{ $method->delivery_method_id }}"
                                           onchange="showDeliveryInfo({{ $method->delivery_method_id }})"
                                        {{ old('delivery_method_id') == $method->delivery_method_id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="delivery_{{ $method->delivery_method_id }}">
                                        {{ $method->name }}
                                    </label>
                                </div>
                                <h6 class="mb-0"><strong>{{ number_format($method->price, 2) }} €</strong></h6>
                            </div>
                            <div class="text-muted mt-1 ms-4" style="font-size: 0.85rem;">
                                {{ $method->description }}
                            </div>

                            {{-- Extra polia pre každú metódu --}}
                            <div id="delivery-extra-{{ $method->delivery_method_id }}"
                                 class="mt-2 ms-4 ps-1"
                                 style="display: {{ old('delivery_method_id') == $method->delivery_method_id ? 'block' : 'none' }}">

                                @if($method->name === 'DHL')
                                    <div class="row gy-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Phone number for courier</label>
                                            <input type="text" name="dhl_phone" class="form-control login-input @error('dhl_phone') is-invalid @enderror"
                                                   placeholder="+421 900 000 000"
                                                   value="{{ old('dhl_phone') }}">
                                            @error('dhl_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Delivery time preference</label>
                                            <select name="dhl_time" class="form-select login-input @error('dhl_time') is-invalid @enderror">
                                                <option value="">-- Select --</option>
                                                <option value="morning" {{ old('dhl_time') == 'morning' ? 'selected' : '' }}>Morning (8:00 - 12:00)</option>
                                                <option value="afternoon" {{ old('dhl_time') == 'afternoon' ? 'selected' : '' }}>Afternoon (12:00 - 17:00)</option>
                                                <option value="evening" {{ old('dhl_time') == 'evening' ? 'selected' : '' }}>Evening (17:00 - 20:00)</option>
                                            </select>
                                            @error('dhl_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Delivery address (if different)</label>
                                            <input type="text" name="dhl_address" class="form-control login-input"
                                                   placeholder="Street, City, Postal Code"
                                                   value="{{ old('dhl_address') }}">
                                        </div>
                                    </div>

                                @elseif($method->name === 'Packeta')
                                    <div class="row gy-2">
                                        <div class="col-md-6">
                                            <label class="form-label">City</label>
                                            <select name="packeta_city" class="form-select login-input @error('packeta_city') is-invalid @enderror" onchange="updatePacketaPoints(this.value)">
                                                <option value="">-- Select city --</option>
                                                <option value="Bratislava" {{ old('packeta_city') == 'Bratislava' ? 'selected' : '' }}>Bratislava</option>
                                                <option value="Košice" {{ old('packeta_city') == 'Košice' ? 'selected' : '' }}>Košice</option>
                                                <option value="Žilina" {{ old('packeta_city') == 'Žilina' ? 'selected' : '' }}>Žilina</option>
                                                <option value="Prešov" {{ old('packeta_city') == 'Prešov' ? 'selected' : '' }}>Prešov</option>
                                                <option value="Nitra" {{ old('packeta_city') == 'Nitra' ? 'selected' : '' }}>Nitra</option>
                                            </select>
                                            @error('packeta_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pickup point</label>
                                            <select name="packeta_point" class="form-select login-input @error('packeta_point') is-invalid @enderror" id="packeta-point-select">
                                                <option value="">-- Select city first --</option>
                                            </select>
                                            @error('packeta_point') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                @elseif($method->name === 'Slovenská pošta')
                                    <div class="row gy-2">
                                        <div class="col-md-6">
                                            <label class="form-label">City</label>
                                            <select name="post_city" class="form-select login-input @error('post_city') is-invalid @enderror" onchange="updatePostaPoints(this.value)">
                                                <option value="">-- Select city --</option>
                                                <option value="Bratislava" {{ old('post_city') == 'Bratislava' ? 'selected' : '' }}>Bratislava</option>
                                                <option value="Košice" {{ old('post_city') == 'Košice' ? 'selected' : '' }}>Košice</option>
                                                <option value="Žilina" {{ old('post_city') == 'Žilina' ? 'selected' : '' }}>Žilina</option>
                                                <option value="Prešov" {{ old('post_city') == 'Prešov' ? 'selected' : '' }}>Prešov</option>
                                                <option value="Nitra" {{ old('post_city') == 'Nitra' ? 'selected' : '' }}>Nitra</option>
                                            </select>
                                            @error('post_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Post office</label>
                                            <select name="post_point" class="form-select login-input @error('post_point') is-invalid @enderror" id="post_point-select">
                                                <option value="">-- Select city first --</option>
                                            </select>
                                            @error('post_point') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                @endif
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
                        <div class="mb-2">
                            <div class="d-flex gap-2 align-items-center">
                                <input class="form-check-input" type="radio"
                                       name="payment_method_id"
                                       id="payment_{{ $method->payment_method_id }}"
                                       value="{{ $method->payment_method_id }}"
                                       onchange="showPaymentInfo({{ $method->payment_method_id }})"
                                    {{ old('payment_method_id') == $method->payment_method_id ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_{{ $method->payment_method_id }}">
                                    {{ $method->name }}
                                </label>
                            </div>
                            <div class="text-muted mt-1 ms-4" style="font-size: 0.85rem;">
                                {{ $method->description }}
                            </div>

                            {{-- Extra polia pre každú metódu --}}
                            <div id="payment-extra-{{ $method->payment_method_id }}"
                                 class="mt-2 ms-4 ps-1"
                                 style="display: {{ old('payment_method_id') == $method->payment_method_id ? 'block' : 'none' }}">

                                @if($method->name === 'By card')
                                    <div class="row gy-2">
                                        <div class="col-12">
                                            <label class="form-label">Card Number</label>
                                            <input type="text" name="card_number" class="form-control login-input @error('card_number') is-invalid @enderror"
                                                   placeholder="1234 5678 9012 3456" maxlength="19"
                                                   value="{{ old('card_number') }}">
                                            @error('card_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Cardholder Name</label>
                                            <input type="text" name="card_name" class="form-control login-input @error('card_name') is-invalid @enderror"
                                                   placeholder="John Doe"
                                                   value="{{ old('card_name') }}">
                                            @error('card_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Expiry Date</label>
                                            <input type="text" name="card_expiry" class="form-control login-input @error('card_expiry') is-invalid @enderror"
                                                   placeholder="MM/YY" maxlength="5"
                                                   value="{{ old('card_expiry') }}">
                                            @error('card_expiry') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">CVV</label>
                                            <input type="password" name="card_cvv" class="form-control login-input @error('card_cvv') is-invalid @enderror"
                                                   placeholder="•••" maxlength="4">
                                            @error('card_cvv') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                @elseif($method->name === 'Bank transfer')
                                    <div class="detail-card p-3 mt-2">
                                        <p class="mb-1"><strong>Transfer to our account:</strong></p>
                                        <p class="mb-1">IBAN: <strong>SK89 0900 0000 0051 2345 6789</strong></p>
                                        <p class="mb-1">Bank: Slovenská sporiteľňa</p>
                                        <p class="mb-0">Variable symbol: your order number (sent after placing order)</p>
                                        <hr class="my-2">
                                        <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                            After we register your payment, we will send you a confirmation email and ship your order within 1-2 business days.
                                        </p>
                                    </div>
                                @endif
                            </div>
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
                            <span id="delivery-price-display">— €</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h4><strong>Total:</strong></h4>
                            <h4><strong id="total-display">{{ number_format($subtotal, 2) }} €</strong></h4>
                        </div>
                        <button type="submit" class="login-button">Confirm Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const deliveryPrices = {
            @foreach($deliveryMethods as $method)
                {{ $method->delivery_method_id }}: {{ $method->price }},
            @endforeach
        };
        const subtotal = {{ $subtotal }};

        const packetaPoints = {
            'Bratislava': ['Packeta - Obchodná 5, Bratislava', 'Packeta - Mlynské nivy 12, Bratislava'],
            'Košice':     ['Packeta - Hlavná 3, Košice', 'Packeta - Rooseveltova 7, Košice'],
            'Žilina':     ['Packeta - Národná 2, Žilina', 'Packeta - Hurbanova 9, Žilina'],
            'Prešov':     ['Packeta - Hlavná 10, Prešov', 'Packeta - Námestie mieru 4, Prešov'],
            'Nitra':      ['Packeta - Štefánikova 1, Nitra', 'Packeta - Kupecká 6, Nitra'],
        };

        const postaPoints = {
            'Bratislava': ['Pošta Bratislava 1 - Námestie SNP 35', 'Pošta Bratislava 2 - Ružinovská 4'],
            'Košice':     ['Pošta Košice 1 - Poštová 2', 'Pošta Košice 2 - Trieda SNP 51'],
            'Žilina':     ['Pošta Žilina 1 - Národná 7', 'Pošta Žilina 2 - Vlčincová 5'],
            'Prešov':     ['Pošta Prešov 1 - Hlavná 50', 'Pošta Prešov 2 - Arm. gen. Svobodu 15'],
            'Nitra':      ['Pošta Nitra 1 - Štefánikova 60', 'Pošta Nitra 2 - Chrenovská 32'],
        };

        function showDeliveryInfo(id) {
            document.querySelectorAll('[id^="delivery-extra-"]').forEach(el => el.style.display = 'none');
            document.getElementById('delivery-extra-' + id).style.display = 'block';

            const price = deliveryPrices[id] || 0;
            document.getElementById('delivery-price-display').textContent = price.toFixed(2).replace('.', ',') + ' €';
            document.getElementById('total-display').textContent = (subtotal + price).toFixed(2).replace('.', ',') + ' €';
        }

        function showPaymentInfo(id) {
            document.querySelectorAll('[id^="payment-extra-"]').forEach(el => el.style.display = 'none');
            document.getElementById('payment-extra-' + id).style.display = 'block';
        }

        function updatePacketaPoints(city) {
            const select = document.getElementById('packeta-point-select');
            select.innerHTML = '<option value="">-- Select point --</option>';
            if (packetaPoints[city]) {
                packetaPoints[city].forEach(point => {
                    select.innerHTML += `<option value="${point}">${point}</option>`;
                });
            }
        }

        function updatePostaPoints(city) {
            const select = document.getElementById('posta-pobocka-select');
            select.innerHTML = '<option value="">-- Select post office --</option>';
            if (postaPoints[city]) {
                postaPoints[city].forEach(point => {
                    select.innerHTML += `<option value="${point}">${point}</option>`;
                });
            }
        }

        const cardInput = document.querySelector('input[name="card_number"]');
        if (cardInput) {
            cardInput.addEventListener('input', function() {
                let val = this.value.replace(/\D/g, '').substring(0, 16);
                this.value = val.replace(/(.{4})/g, '$1 ').trim();
            });
        }

        const expiryInput = document.querySelector('input[name="card_expiry"]');
        if (expiryInput) {
            expiryInput.addEventListener('input', function() {
                let val = this.value.replace(/\D/g, '').substring(0, 4);
                if (val.length >= 2) val = val.substring(0, 2) + '/' + val.substring(2);
                this.value = val;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkedDelivery = document.querySelector('input[name="delivery_method_id"]:checked');
            if (checkedDelivery) showDeliveryInfo(parseInt(checkedDelivery.value));

            const checkedPayment = document.querySelector('input[name="payment_method_id"]:checked');
            if (checkedPayment) showPaymentInfo(parseInt(checkedPayment.value));

            @if(old('packeta_city'))
            updatePacketaPoints('{{ old('packeta_city') }}');
            document.querySelector('#packeta-point-select option[value="{{ old('packeta_point') }}"]')?.setAttribute('selected', 'selected');
            @endif

            @if(old('post_city'))
            updatePostaPoints('{{ old('post_city') }}');
            document.querySelector('#post_point-select option[value="{{ old('post_point') }}"]')?.setAttribute('selected', 'selected');
            @endif
        });
    </script>
@endsection
