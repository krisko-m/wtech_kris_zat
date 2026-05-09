@extends('layouts.app')

@section('title', 'Log Out')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/myaccount.css">
@endsection

@section('content')
    <main class="container my-5">
        <div class="row gap-4">

            @include('myaccount.sidebar')

            <div class="col">
                <h2 class="account-heading mb-4">Log Out</h2>

                <div class="account-card">
                    <h5 class="account-card-title mb-4">Are you sure you want to Log Out?</h5>

                    <div class="d-flex gap-3 mt-3">
                        <button onclick="location.href='/'" class="btn account-back-btn">Back Home</button>

                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn account-save-btn">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
