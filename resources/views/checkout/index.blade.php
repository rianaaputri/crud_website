@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Checkout</h3>
    <div class="card p-4">
        <h4>{{ $product->title }}</h4>
        <p>Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        <form action="{{ route('checkout.paymentPage') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" id="product-price" value="{{ $product->price }}">
            <input type="hidden" name="total_price" id="total-hidden">

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="{{ $product->stock }}" required>
            </div>

            <div class="mb-3">
                <label>Total</label>
                <input type="text" id="total-price" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label>Voucher</label>
                <input type="text" name="voucher_code" class="form-control" placeholder="Masukkan kode voucher">
            </div>

            <button type="submit" class="btn btn-primary">Lanjut ke Pembayaran</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const price = parseInt(document.getElementById('product-price').value);
    const qtyInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total-price');
    const totalHidden = document.getElementById('total-hidden');

    qtyInput.addEventListener('input', function () {
        let qty = parseInt(qtyInput.value) || 0;
        let total = qty * price;
        totalDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
        totalHidden.value = total;
    });
});
</script>
@endsection
