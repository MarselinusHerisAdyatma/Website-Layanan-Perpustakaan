@extends('templates.auth')

@section('content-auth')

<!-- Header -->
<div class="header">
    <img class="img" src="{{ asset('images/Logo Perpus Unila.png') }}" alt="Perpustakaan Logo">
    <div class="close">
        <a href="{{ route('landing_page') }}">
            <i class="bi bi-arrow-left-circle fs-2"></i>
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-wrapper">
    <div class="content">
        <p>Silakan masukkan username dan password Anda untuk login ke sistem layanan perpustakaan.</p>

        <!-- @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif -->

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                <small>
                    <a href="{{ route('password.request') }}" class="forgot-password-link">Lupa Password?</a>
                </small>
            </div>
            

            <button type="submit" class="btn btn-submit w-100">Login</button>
        </form>
    </div>
</div>
