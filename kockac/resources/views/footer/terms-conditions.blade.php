@extends('layouts.app')

@section('title', 'Add Product - Kockac')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/product-detail.css">
    <link rel="stylesheet" type="text/css" href="/css/login.css">
@endsection

@section('content')
    <main class="container my-5">
        <div class="detail-card" style="text-align: left !important; padding: 50px;">
            <h1><strong>Terms and Conditions</strong></h1>

            <p>Welcome to Kockáč. These Terms and Conditions govern your use of our website and the purchase of products from our online store.
                <br/>
                By accessing this website and/or placing an order, you agree to be bound by these Terms and Conditions.
            </p>

            <hr/>

            <h2>1. Company Information</h2>

            <p>This online store is operated by:</p>
            <ul>
                <li>Company name: Kockáč</li>
                <li>Phone number: +421 234 567 891</li>
                <li>Email: kockac-games@kockac.gg</li>
                <li>Company registration number: 1234 5678</li>
            </ul>

            <hr/>

            <h2>2. Definitions</h2>

            <p>In these Terms and Conditions:</p>
            <ul>
                <li>"Store", "we", "us", or "our" refers to Kockáč.</li>
                <li>"Customer", "you", or "your" refers to any person purchasing products from the Store.</li>
                <li>"Products" refers to goods sold through the Store.</li>
            </ul>

            <hr/>

            <h2>3. Eligibility</h2>

            <p>By using this website, you confirm that:</p>
            <ul>
                <li>You are at least 18 years old or have parental/guardian consent</li>
                <li>The information you provide is accurate and complete.</li>
                <li>You are legally capable of entering binding contracts.</li>
            </ul>

            <hr/>

            <h2>4. Products and Availability</h2>

            <p>We make every effort to ensure that product descriptions, images, pricing and availability are accurate.
            <br>However:
            </p>
            <ul>
                <li>Product images may differ slightly from actual product.</li>
                <li>Colors may vary depending on your screen settings.</li>
                <li>We reserve the right to discontinue products at any time.</li>
                <li>Product availability is not guaranteed.</li>
            </ul>

            <p>If a product becomes unavailable after an order is placed, we will notify you and offer a refund or replacement
            where applicable.
            </p>

            <hr/>

            <h2>5. Pricing</h2>

            <p>
                All prices displayed on the website are listed in € (Euro) and include VAT where applicable.
                <br>
                We reserve the right to change prices at any time without prior notice.
                <br>
                Shipping costs, taxes, and additional fees will be displayed before checkout.
            </p>

            <hr/>

            <h2>6. Orders</h2>

            <p>When placing an order:</p>
            <ol>
                <li>You agree that all information  provided is accurate.</li>
                <li>Your order constitutes an offer to purchase products.</li>
                <li>We reserve the right to refuse or cancel any order.</li>
            </ol>

            <p>An order confirmation email does not constitute acceptance of the order.</p>
            <p>The contract is formed only when the products are dispatched.</p>
            <hr/>

            <h2>7. Payment</h2>

            <p>We accept payment methods listed during checkout.</p>
            <p>Payments must be completed before orders are shipped.</p>
            <p>We reserve the right to cancel orders suspected of fraud or unauthorized activity.</p>

        </div>

    </main>
@endsection
