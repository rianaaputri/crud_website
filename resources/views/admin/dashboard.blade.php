<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin Ririshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
        }
        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: white;
            position: fixed;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 220px;
            flex-grow: 1;
            padding: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center py-3 border-bottom">Admin Ririshop</h4>
        <a href="{{ route('admin.produk') }}">Produk</a>
        <a href="{{ route('admin.orders') }}" >Semua Pesanan</a>
      <a href="{{ route('admin.seller.index') }}">Akun Penjual</a>
      <a href="{{ route('admin.customer.index') }}">Akun Pelanggan</a>
        <a href="{{ route('admin.voucher.index')}}">Diskon & Voucher</a>
        <a href="#">Laporan</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-3">
            <div class="container-fluid">
                <span class="navbar-brand">Dashboard</span>
                <div class="d-flex">
                    <a href="{{ route('admin.register') }}" class="btn btn-outline-primary me-2">Tambah Admin</a>
                    <a href="{{ route('admin.logout') }}" class="btn btn-outline-danger">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Konten Halaman -->
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
