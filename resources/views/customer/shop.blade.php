<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Toko Anda - RiriShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

{{-- Navbar --}}
<nav class="navbar navbar-light bg-white shadow-sm px-4 mb-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-dark" href="{{ route('products.index') }}">
            🛍️ RiriShop
        </a>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark">🏠 Home</a>

            {{-- Dropdown Profil --}}
            <div class="dropdown">
                <button class="btn btn-light border rounded-circle dropdown-toggle d-flex align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}" alt="Avatar"
                         class="rounded-circle me-2" style="width: 40px; height: 40px;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}">👤 Profil Saya</a></li>
                    <li><a class="dropdown-item" href="{{ route('customer.shop') }}">🛒 Toko Anda</a></li>
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

{{-- Konten --}}
<div class="container mt-4">
    <h3 class="text-center mb-4">Toko Anda</h3>

    <div class="card mb-4 p-3">
        <p><strong>Nama Pemilik:</strong> {{ $customer->name }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <hr>
        <p><strong>Nama Toko:</strong> {{ $customer->store_name }}</p>
        <p><strong>Deskripsi Toko:</strong> {{ $customer->store_description }}</p>
    </div>

    {{-- Tambah Produk --}}
    <div class="d-flex gap-2">
        <a href="{{ route('customer.orders.incoming') }}" class="btn btn-outline-primary">
            📥 Pesanan Masuk
        </a>
        <a href="{{ route('products.create') }}" class="btn btn-success">➕ Add Product</a>
</div>
<br>
    {{-- Produk Seller --}}
    <h4>Produk yang Anda Jual</h4>
    <div class="row mt-3">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top"
                         alt="{{ $product->title }}" style="object-fit: cover; height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">
                            <strong>Harga:</strong> {{ "Rp " . number_format($product->price, 2, ',', '.') }}<br>
                            <strong>Stok:</strong> {{ $product->stock }}
                        </p>
                    </div>
                    <div class="card-footer text-center bg-white border-0">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-dark">SHOW</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                              class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">Belum ada produk milik Anda.</div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
