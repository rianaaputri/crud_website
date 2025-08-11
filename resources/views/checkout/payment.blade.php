@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pembayaran</h3>
    <p>Produk: {{ $product->title }}</p>
    <p>Jumlah: {{ $quantity }}</p>
    <p>Total yang harus dibayar: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></p>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="{{ $quantity }}">
        <input type="hidden" name="total" value="{{ $total }}">
        @if($voucher)
    <input type="hidden" name="voucher_id" value="{{ $voucher->id }}">
@endif


        <div class="mb-3">
            <label>Jumlah Uang yang Dibayarkan</label>
            <input type="number" name="payment_amount" class="form-control" min="{{ $total }}" required>
        </div>

        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
    </form>
</div>
@endsection
