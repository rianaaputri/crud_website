@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1>⏳ Transaksi Menunggu Pembayaran</h1>
    <p>Silakan selesaikan pembayaran kamu melalui metode yang telah dipilih.</p>
    <p>Kami akan memproses pesanan kamu setelah pembayaran berhasil.</p>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Kembali ke Produk</a>
</div>
@endsection
