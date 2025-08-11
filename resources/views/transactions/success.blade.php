@extends('layouts.app')

@section('content')
<div class="text-center mt-5">
    <h1>✅ Pembayaran Berhasil!</h1>
    <p>Terima kasih sudah berbelanja di RiriShop</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
