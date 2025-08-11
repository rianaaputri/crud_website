@extends('layouts.admin')

@section('content')
    <h3>Detail Seller</h3>
    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Nama Toko :{{$user->store_name}}</strong></p>
    <p><strong>Deskripsi Toko :{{$user->store_description}}</strong></p>
    <a href="{{ route('admin.seller.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
