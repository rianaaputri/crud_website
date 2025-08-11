<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

{{-- Navbar --}}<nav class="navbar navbar-light bg-white shadow-sm px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-dark" href="{{ route('products.index') }}">
            🛍️ RiriShop
        </a>

        {{-- Navigasi kanan --}}
        <div class="d-flex align-items-center gap-3">

            {{-- Tombol Home --}}
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
                🏠 Home
            </a>

            {{-- Tombol Mulai Jual jika role adalah 'customer' --}}
            @if($customer->role === 'customer')
                <a href="{{ route('customer.seller.form') }}" class="btn btn-warning">
                    ✨ Mulai Jual
                </a>
            @endif
@auth('customer')
    <a href="{{ route('customer.orders.incoming') }}" class="btn btn-outline-secondary">🧾 Pesanan Saya</a>
@endauth

            {{-- Dropdown Profil --}}
            <div class="dropdown">
                <button class="btn btn-light border rounded-circle dropdown-toggle d-flex align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}" alt="Avatar"
                         class="rounded-circle me-2" style="width: 40px; height: 40px;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">

                    {{-- Jika seller, tampilkan link toko --}}
                    @if($customer->role === 'seller')
                        <li><a class="dropdown-item" href="{{ route('customer.shop') }}">🛒 Toko Anda</a></li>
                    @endif

                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}">👤 Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">🚪 Logout</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>


{{-- Konten Profil --}}
<div class="container mt-5">
    <h3 class="text-center mb-4">Profil Anda</h3>

    <div class="card mb-4 p-3">
        <p><strong>Nama:</strong> {{ $customer->name }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
