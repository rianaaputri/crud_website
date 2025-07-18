@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h4 class="mb-3">Reset Password</h4>

    <form method="POST" action="{{ route('customer.password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label>Password Baru:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-primary">Reset Password</button>
    </form>
</div>
@endsection
