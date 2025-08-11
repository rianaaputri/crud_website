<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk - RiriShop</title>
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
            {{-- Profil --}}
            <div class="dropdown">
                @php
    use Illuminate\Support\Facades\Auth;
@endphp

                <button class="btn btn-light border rounded-circle dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="Avatar"
                         class="rounded-circle me-2" style="width: 40px; height: 40px;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
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

{{-- Konten --}}
<div class="container mt-5">
    <h3 class="text-center mb-4">📥 Daftar Pesanan Masuk ke Toko Anda</h3>

    @if($transactions->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($transactions as $trx)
                        <tr>
                            <td>{{ $trx->user->name ?? '-' }}</td>
                            <td>
                                {{ $trx->product->title ?? '-' }} <br>
                                @if($trx->product && $trx->product->image)
                                    <img src="{{ asset('storage/products/' . $trx->product->image) }}" alt="{{ $trx->product->title }}" width="60">
                                @endif
                            </td>
                            <td>{{ $trx->quantity }}</td>
                            <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($trx->payment_method) }}</td>
                            <td>
                                <span class="badge bg-{{ $trx->status === 'selesai' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>
    <span class="badge bg-{{ $trx->status === 'selesai' ? 'success' : 'secondary' }}">
        {{ ucfirst($trx->status) }}
    </span>

    {{-- Tombol aksi dinamis sesuai status transaksi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="mt-2">
       @if($trx->status === 'menunggu')
    <button class="btn btn-sm btn-warning"
        onclick="confirmUpdate('{{ $trx->id }}', 'sedang dikemas')">Kerjakan</button>
@elseif($trx->status === 'sedang dikemas')
    <button class="btn btn-sm btn-info mt-1"
        onclick="confirmUpdate('{{ $trx->id }}', 'diantarkan')">Antarkan</button>
@endif
<script>
    function confirmUpdate(id, status) {
        let message = status === 'sedang dikemas' ? 'Pesanan dikemas?' : 'Pesanan diantar?';

        Swal.fire({
            title: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat dan submit form secara dinamis
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/transaction/${id}/status/${status}`;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

    </div>
</td>

                        </tr>
                        @php $grandTotal += $trx->total_price; @endphp
                    @endforeach
                    {{-- Total Keseluruhan --}}
                    <tr>
                        <td colspan="6" class="text-end fw-bold">Total Pesanan Masuk</td>
                        <td class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">Belum ada pesanan masuk.</div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
