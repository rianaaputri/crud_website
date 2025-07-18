@extends('layouts.admin')

@section('content')
    <h3>Detail Seller</h3>
    <p><strong>Nama:</strong> {{ $customer->name }}</p>
    <p><strong>Email:</strong> {{ $customer->email }}</p>
    <p><strong>Nama Toko :{{$customer->store_name}}</strong></p>
    <p><strong>Deskripsi Toko :{{$customer->store_description}}</strong></p>
    <a href="{{ route('admin.seller.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
