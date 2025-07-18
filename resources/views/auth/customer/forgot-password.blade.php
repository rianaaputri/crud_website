@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h4 class="mb-3">Lupa Password</h4>

   @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif


    <form method="POST" action="{{ route('customer.password.email') }}">
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button class="btn btn-primary">Kirim Link Reset Password</button>
    </form>
</div>
@endsection
