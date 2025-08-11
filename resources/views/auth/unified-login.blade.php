@extends('layouts.app')

@section('content')
<!-- Tambahkan Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Riri Shop</h2>
            <p class="text-muted">Login ke akun Anda</p>
        </div>

        {{-- Session status message --}}
        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif

        {{-- Error message (invalid login) --}}
        @if ($errors->has('email'))
            <div class="alert alert-danger mb-3">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            {{-- Password dengan toggle --}}
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" class="form-control" type="password" name="password" required>
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            {{-- Remember me --}}
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember_me" class="form-check-input">
                <label class="form-check-label" for="remember_me">Ingat saya</label>
            </div>

            {{-- Forgot password & Register --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a class="text-decoration-none small" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
                <a class="text-decoration-none small" href="{{ route('customer.register') }}">
                    Daftar akun
                </a>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary w-100">
                Masuk
            </button>
        </form>
    </div>
</div>

{{-- Script toggle password --}}
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        this.innerHTML = type === "password"
            ? '<i class="bi bi-eye"></i>'
            : '<i class="bi bi-eye-slash"></i>';
    });
</script>
@endsection
