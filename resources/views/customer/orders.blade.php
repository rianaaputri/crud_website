<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya - RiriShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

{{-- Navbar --}}
<nav class="navbar navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-dark" href="{{ route('products.index') }}">
            🛍️ RiriShop
        </a>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark">🏠 Home</a>
 <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">🧾 Pesanan Saya</a>
            @if($customer->role === 'customer')
                <a href="{{ route('customer.seller.form') }}" class="btn btn-warning">✨ Mulai Jual</a>
            @endif

           

            {{-- Dropdown Profil --}}
            <div class="dropdown">
                <button class="btn btn-light border rounded-circle dropdown-toggle d-flex align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}" alt="Avatar"
                         class="rounded-circle me-2" style="width: 40px; height: 40px;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @if($customer->role === 'seller')
                        <li><a class="dropdown-item" href="{{ route('customer.shop') }}">🛒 Toko Anda</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}">👤 Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">🚪 Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- Konten Pesanan --}}
<div class="container mt-5">
    <h3 class="text-center mb-4">🧾 Daftar Pesanan Anda</h3>

    @if($transactions->count())

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Gambar</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($transactions as $trx)
        <tr>
            <td class="text-center">
                @if($trx->product && $trx->product->image)
                    <img src="{{ asset('storage/products/' . $trx->product->image) }}" alt="{{ $trx->product->title }}" width="60">
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ $trx->product->title ?? '-' }}</td>
            <td class="text-center">{{ $trx->quantity }}</td>
            <td class="text-center">{{ ucfirst($trx->payment_method) }}</td>
            <td class="text-center">{{ ucfirst($trx->status) }}</td>
            <td class="text-center">{{ $trx->created_at->format('d-m-Y H:i') }}</td>
        </tr>
    @endforeach

    {{-- Baris Total Pesanan --}}
    <tr class="fw-bold bg-light">
        <td colspan="4" class="text-end">Total Pesanan:</td>
        <td colspan="2" class="text-end">Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}</td>
    </tr>
</tbody>

            </table>
        </div>

        {{-- Total Semua Transaksi (optional, hapus jika tidak dibutuhkan) --}}
        <div class="d-flex justify-content-end mt-3">
            <div class="bg-white p-3 rounded shadow-sm">
                <h5 class="m-0">
                    🧾 <strong>Total Semua Transaksi:</strong> 
                    Rp {{ number_format($transactions->sum('total_price'), 0, ',', '.') }}
                </h5>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            Belum ada pesanan yang Anda lakukan.
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
