@extends('layouts.auth')

@section('title', 'Login - Kockac')

@section('content')
    <main class="container my-3">
        <!--Login Card-->
        <div class="d-flex justify-content-center p-4">
            <div class="login-card">
                <h2 class="login-title">Login</h2>

                <form method="POST" action="/login">
                    @csrf

                    <!--Email / Username input-->
                    <div class="mb-3">
                        <input id="login" name="login" type="text"
                            class="form-control login-input w-100 @error('login') is-invalid @enderror"
                            placeholder="E-Mail / Username"
                            value="{{ old('login') }}"
                            autocomplete="username">

                        @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--Password input-->
                    <div class="mb-3">
                        <input id="password" name="password" type="password"
                            class="form-control login-input w-100 @error('password') is-invalid @enderror"
                            placeholder="Password"
                            autocomplete="current-password"
                        >
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--Remember me + Forgot password-->
                    <div class="text-start d-flex flex-row justify-content-between mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="RememberMe">
                            <label class="form-check-label" for="RememberMe">Remember Me</label>
                        </div>
                        <a href='javascript:void(0)' class="login-forgot" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
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

    @include('modals.forgot-password')
@endsection

@section('scripts')
    <script src=" {{ asset('js/forgot-password-script.js') }} "></script>
@endsection
