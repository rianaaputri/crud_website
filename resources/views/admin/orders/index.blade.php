@extends('layouts.admin')

@section('title', 'Semua Pesanan - Admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">📋 Semua Transaksi Pelanggan</h3>

    @if($transactions->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Customer</th>
                        <th>Toko</th>
                        <th>Produk</th>
                        <th>Gambar</th>
                        <th>Jumlah</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                        <tr>
                            <td>{{ $trx->user->name ?? '-' }}</td>
                            <td>{{ $trx->product->user->store_name ?? '-' }}</td>
                            <td>{{ $trx->product->title ?? '-' }}</td>
                            <td class="text-center">
                                @if($trx->product && $trx->product->image)
                                    <img src="{{ asset('storage/products/' . $trx->product->image) }}" width="60" alt="image">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $trx->quantity }}</td>
                            <td class="text-center">{{ ucfirst($trx->payment_method) }}</td>
                            <td class="text-center">{{ ucfirst($trx->status) }}</td>
                            <td class="text-center">{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                            <td class="text-end">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">Belum ada transaksi yang tercatat.</div>
    @endif
</div>
@endsection
