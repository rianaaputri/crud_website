@extends('layouts.admin')

@section('content')
    <h3>Detail Customer</h3>
    <p><strong>Nama:</strong> {{ $customer->name }}</p>
    <p><strong>Email:</strong> {{ $customer->email }}</p>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
