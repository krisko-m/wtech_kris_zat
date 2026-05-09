@extends('layouts.app')

@section('title', 'Change Password')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/myaccount.css">
@endsection

@section('content')
    <main class="container my-5">
        <div class="row gap-4">

            @include('myaccount.sidebar')

            <div class="col">
                <h2 class="account-heading mb-4">Change Password</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="account-card">
                    <form method="POST" action="/account/change-password">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="account-label">Current Password</label>
                                <input name="current_password" type="password"
                                       class="form-control account-input @error('current_password') is-invalid @enderror">
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-2 g-3">
                            <div class="col-md-6">
                                <label class="account-label">New Password</label>
                                <input name="password" type="password"
                                       class="form-control account-input @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="account-label">Repeat Password</label>
                                <input name="password_confirmation" type="password"
                                       class="form-control account-input">
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn account-save-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
