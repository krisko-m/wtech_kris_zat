<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kockac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/kocka-tab.png') }}">
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="/css/login.css">
</head>
<body>
<main>
    <!--Logo at the top-->
    <a href="{{ url('/') }}">
        <div class="text-center mt-4">
            <img src="{{ asset('assets/kockac-logo-rec.png') }}" alt="Kockáč" height="70">
        </div>
    </a>

    <!--Login Card-->
    <div class="d-flex justify-content-center p-4">
        <div class="login-card">
            <h2 class="login-title">Login</h2>

            {{-- Chybové hlášky --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Success správa po registrácii --}}
            @if (session('success'))
                <div class="alert alert-success py-2 mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <!--Email / Username input-->
                <div class="mb-3">
                    <input
                        id="login"
                        name="login"
                        type="text"
                        class="form-control login-input w-100 @error('login') is-invalid @enderror"
                        placeholder="E-Mail / Username"
                        value="{{ old('login') }}"
                        autocomplete="username"
                    >
                </div>

                <!--Password input-->
                <div class="mb-3">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-control login-input w-100 @error('password') is-invalid @enderror"
                        placeholder="Password"
                        autocomplete="current-password"
                    >
                </div>

                <!--Remember me + Forgot password-->
                <div class="text-start d-flex flex-row justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="RememberMe">
                        <label class="form-check-label" for="RememberMe">Remember Me</label>
                    </div>
                    <a href="{{ url('/forgot-password') }}" class="login-forgot">Forgot Password?</a>
                </div>

                <!--Login button-->
                <div class="d-grid gap-2">
                    <button type="submit" class="login-button">LOG IN</button>
                </div>
            </form>

            <!--SignUp link-->
            <div class="text-center mt-3">
                <a href="/register" class="login-signup">SIGN UP</a>
            </div>
        </div>
    </div>
</main>

<!-- Back button -->
<div class="login-back">
    <button onclick="location.href='{{ url('/') }}'" class="back-button">Back to Shop</button>
</div>

<!--Footer-->
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
