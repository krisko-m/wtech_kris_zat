@extends('layouts.auth')

@section('title', 'Login - Kockac')

@section('content')
    <main class="container my-3">
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
@endsection

