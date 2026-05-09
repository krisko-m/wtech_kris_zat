<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kockac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="/assets/kocka-tab.png">
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>
<body>
<main>
    <a href="{{ url('/') }}">
        <div class="text-center mt-4">
            <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="70">
        </div>
    </a>

    <div class="d-flex justify-content-center p-4">
        <div class="login-card">
            <h2 class="login-title">Register</h2>

            <form method="POST" action="/register">
                @csrf

                <!--First & Last Name-->
                <div class="row gy-3 mb-3">
                    <div class="col-md-6">
                        <input name="first_name" type="text"
                               class="form-control login-input w-100 @error('first_name') is-invalid @enderror"
                               placeholder="First Name"
                               value="{{ old('first_name') }}">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <input name="last_name" type="text"
                               class="form-control login-input w-100 @error('last_name') is-invalid @enderror"
                               placeholder="Last Name"
                               value="{{ old('last_name') }}">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--Username-->
                <div class="mb-3">
                    <input name="username" type="text"
                           class="form-control login-input w-100 @error('username') is-invalid @enderror"
                           placeholder="Username"
                           value="{{ old('username') }}">
                    @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!--Email-->
                <div class="mb-3">
                    <input name="email" type="email"
                           class="form-control login-input w-100 @error('email') is-invalid @enderror"
                           placeholder="Email"
                           value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!--Password-->
                <div class="mb-3">
                    <input name="password" type="password"
                           class="form-control login-input w-100 @error('password') is-invalid @enderror"
                           placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!--Confirm Password-->
                <div class="mb-3">
                    <input name="password_confirmation" type="password"
                           class="form-control login-input w-100"
                           placeholder="Confirm Password">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="login-button">SIGN UP</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="/login" class="login-signup">LOG IN</a>
            </div>
        </div>
    </div>
</main>

<div class="login-back">
    <button onclick="location.href='/'" class="back-button">Back to Shop</button>
</div>

<footer class="py-4 px-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="50">
        </a>
        <div class="footer-links d-flex gap-4">
            <a href="#">Terms &amp; Conditions</a>
            <a href="#">Privacy Policy</a>
        </div>
        <div class="footer-copy">© 2026 Kockac.com · All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
