@extends('layouts.app')

@section('title', 'Account Settings')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/myaccount.css">
@endsection

@section('content')
    <main class="container my-5">
        <div class="row gap-4">

            @include('myaccount.sidebar')

            <div class="col">
                <h2 class="account-heading mb-4">Account Settings</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="account-card">
                    <h5 class="account-card-title mb-4">Personal Data</h5>

                    <form method="POST" action="/account">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="account-label">First Name</label>
                                <input name="first_name" type="text"
                                       class="form-control account-input @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name', $user->first_name) }}">
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="account-label">Last Name</label>
                                <input name="last_name" type="text"
                                       class="form-control account-input @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name', $user->last_name) }}">
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="account-label">Address</label>
                                <input name="address" type="text"
                                       class="form-control account-input"
                                       value="{{ old('address', $user->address) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="account-label">Postal Code</label>
                                <input name="postal_code" type="text"
                                       class="form-control account-input"
                                       value="{{ old('postal_code', $user->city->postal_code ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="account-label">City</label>
                                <input name="city_name" type="text"
                                       class="form-control account-input"
                                       value="{{ old('city_name', $user->city->city ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="account-label">Country</label>
                                <input name="country" type="text"
                                       class="form-control account-input"
                                       value="{{ old('country', $user->city->country ?? 'Slovakia') }}">
                            </div>

                            <div class="col-12">
                                <label class="account-label">Login Email</label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="email" class="form-control account-input"
                                           value="{{ $user->email }}" disabled>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn account-save-btn">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
