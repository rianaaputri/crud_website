<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body style="background: lightgray">
{{-- Navbar --}}
<nav class="navbar navbar-light bg-white shadow-sm px-4 mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand fw-bold text-dark" href="{{ route('products.index') }}">
            🛍️ RiriShop
        </a>
        <div class="d-flex align-items-center gap-2">
          @guest('customer')
    <a href="{{ route('login') }}" class="btn btn-outline-primary">🔐 Login</a>
    <a href="{{ route('customer.register') }}" class="btn btn-outline-success">📝 Daftar</a>
@else
    <a href="{{ route('products.index') }}" class="btn btn-outline-dark">🏠 Home</a>
@auth('customer')
    <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">🧾 Pesanan Saya</a>
@endauth

    @if(auth('customer')->user()->role === 'customer')
        <a href="{{ route('customer.seller.form') }}" class="btn btn-warning">✨ Mulai Jual</a>
    @endif
@endguest

            {{-- Dropdown Profil --}}
            @if(auth('customer')->check())
            <div class="dropdown">
                <button class="btn btn-light border rounded-circle dropdown-toggle d-flex align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('customer')->user()->name) }}" alt="Avatar"
                         class="rounded-circle me-2" style="width: 40px; height: 40px;">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('customer.profile') }}">👤 Profil Saya</a></li>
                    @if(auth('customer')->user()->role === 'seller')
                        <li><a class="dropdown-item" href="{{ route('customer.shop') }}">🛒 Toko Anda</a></li>
                    @endif
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">🚪 Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if(auth('customer')->check())
</div>
  @endif<form action="{{ route('products.index') }}" method="GET" class="mb-4">
    <div class="position-relative">
        <input type="text" name="search" id="search" class="form-control" placeholder="Cari produk..." autocomplete="off" value="{{ request('search') }}">
        <div id="search-suggestions" class="position-absolute bg-white border rounded shadow-sm w-100" style="z-index: 9999;"></div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Cari</button>
</form>

<!-- ajax -->
<script>
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            let query = $(this).val();
            if (query.length >= 1) {
                $.ajax({
                    url: "{{ route('products.suggestions') }}",
                    type: "GET",
                    data: { search: query },
                    success: function (data) {
                        let suggestions = '';
                        if (data.length > 0) {
                            data.forEach(function (item) {
                                suggestions += `<div class="p-2 suggestion-item" style="cursor:pointer">${item.title}</div>`;
                            });
                        } else {
                            suggestions = '<div class="p-2 text-muted">Tidak ada hasil</div>';
                        }
                        $('#search-suggestions').html(suggestions).show();
                    }
                }, 300);
            } else {
                $('#search-suggestions').hide();
            }
        });

      
        $(document).on('click', '.suggestion-item', function () {
            $('#search').val($(this).text());
            $('#search-suggestions').hide();
        });

        
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#search, #search-suggestions').length) {
                $('#search-suggestions').hide();
            }
        });
    });
</script>
@if(isset($vouchers) && $vouchers->count() > 0)
    <div class="mb-5 p-4 bg-white rounded shadow-sm">
        <h4 class="mb-4">🎟️ Voucher Tersedia</h4>
        <div class="row g-3">
            @foreach($vouchers as $voucher)
                <div class="col-md-4">
                    <div class="card p-3 h-100 border-success">
                        <h5 class="text-success">{{ $voucher->code }}</h5>
                        <p class="mb-1">Diskon: <strong>{{ $voucher->discount }}</strong></p>
                        <p class="text-muted" style="font-size: 0.9rem;">
                            Berlaku: 
                            {{ $voucher->valid_from ? $voucher->valid_from->format('d M Y') : '-' }} 
                            s/d 
                            {{ $voucher->valid_until ? $voucher->valid_until->format('d M Y') : '-' }}
                        </p>
                        <button class="btn btn-sm btn-outline-success w-100 btn-use-voucher" data-code="{{ $voucher->code }}">
    Gunakan
</button>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('/storage/products/'.$product->image) }}"
                                 class="card-img-top"
                                 style="object-fit: cover; height: 200px; border-radius: 5px 5px 0 0;"
                                 alt="{{ $product->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="card-text">
                                    <strong>Harga:</strong> {{ "Rp " . number_format($product->price,2,',','.') }}<br>
                                    <strong>Stok:</strong> {{ $product->stock }}
                                </p>
                            </div>
                            <div class="card-footer text-center bg-white border-0">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-dark">SHOW</a>

                                    @if(auth('customer')->check())
                                       <a href="{{ route('checkout.show', ['product_id' => $product->id, 'voucher_code' => request('voucher_code')]) }}" class="btn btn-sm btn-success mt-2">BUY</a>


                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-sm btn-warning mt-2">Login untuk membeli</a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Pembelian --}}
                    <div class="modal fade" id="buyModal{{ $product->id }}" tabindex="-1" aria-labelledby="buyModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('transactions.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="buyModalLabel{{ $product->id }}">Beli: {{ $product->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Harga Satuan</label>
                                            <input type="text" class="form-control" value="Rp {{ number_format($product->price, 2, ',', '.') }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah</label>
                                            <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->stock }}" placeholder="Jumlah Barang Yang akan dibeli" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Total Harga</label>
                                            <input type="text" id="total_price_{{ $product->id }}" class="form-control" readonly>
                                        </div>
    
                                        <div class="mb-3">
                                            <label class="form-label">Jumlah Uang Dibayar</label>
                                            <input type="number" name="payment_amount" class="form-control" placeholder="Rp." required>
                                        </div>

                                        <div class="mb-3">
    <label class="form-label">Jumlah Uang Dibayar</label>
    <input type="number" name="payment_amount" class="form-control" placeholder="Rp." required>
</div>


                                      
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary btn-pay" 
                                            data-product-id="{{ $product->id }}" 
                                            data-title="{{ $product->title }}"
                                            data-price="{{ $product->price }}">
                                            Bayar
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger">Data Products belum ada.</div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Notifikasi sukses atau gagal
    @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // Perhitungan otomatis total harga di modal
    document.addEventListener("DOMContentLoaded", function () {
        @foreach ($products as $product)
            const quantityInput{{ $product->id }} = document.querySelector('#buyModal{{ $product->id }} input[name="quantity"]');
            const totalField{{ $product->id }} = document.getElementById('total_price_{{ $product->id }}');
            const price{{ $product->id }} = {{ $product->price }};

            if (quantityInput{{ $product->id }}) {
                quantityInput{{ $product->id }}.addEventListener('input', function () {
                    const qty = parseInt(this.value) || 0;
                    const total = qty * price{{ $product->id }};
                    totalField{{ $product->id }}.value = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(total);
                });
            }
        @endforeach
    });
</script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('.btn-pay').on('click', function () {
            let productId = $(this).data('product-id');
            let quantity = $(`#buyModal${productId} input[name='quantity']`).val();
            let paymentMethod = $(`#buyModal${productId} select[name='payment_method']`).val();

            if (!quantity || quantity <= 0) {
                return Swal.fire("Ups!", "Jumlah tidak boleh kosong", "warning");
            }

            $.ajax({
                url: "{{ route('midtrans.token') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: {
                    product_id: productId,
                    quantity: quantity,
                    payment_method: paymentMethod,
                },
                success: function (res) {
                    snap.pay(res.snap_token, {
                        onSuccess: function (result) {
                            window.location.href = "{{ route('transactions.success') }}";
                        },
                        onPending: function (result) {
                            window.location.href = "{{ route('transactions.pending') }}";
                        },
                        onError: function (result) {
                            Swal.fire("Gagal", "Transaksi gagal diproses", "error");
                        }
                    });
                },
                error: function (xhr) {
                    Swal.fire("Error", "Gagal mendapatkan token transaksi", "error");
                }
            });
        });
    });
</script>
<script>
document.querySelectorAll('input[name="voucher_code"]').forEach(function(input) {
    input.addEventListener('blur', function() {
        let code = this.value;
        let productId = this.closest('.modal').querySelector('input[name="product_id"]').value;
        let qty = this.closest('.modal').querySelector('input[name="quantity"]').value;

        if (code && qty > 0) {
            fetch(`/check-voucher?code=${code}&product_id=${productId}&qty=${qty}`)
                .then(res => res.json())
                .then(data => {
                    if (data.valid) {
                        alert(`Voucher valid! Diskon: Rp ${data.discount}`);
                        this.closest('.modal').querySelector('[id^="total_price_"]').value = 
                            new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR'}).format(data.final_total);
                    } else {
                        alert('Voucher tidak valid');
                    }
                });
        }
    });
});
</script>
<script>
    // Fungsi copy kode voucher ke input pencarian atau form voucher di checkout (opsional)
    function copyKode(code) {
        // Contoh: copy ke input voucher di halaman ini (sesuaikan id input voucher kamu)
        const voucherInputs = document.querySelectorAll('input[name="voucher_code"]');
        voucherInputs.forEach(input => {
            input.value = code;
            input.dispatchEvent(new Event('blur')); // trigger validasi voucher jika ada
        });
    }

    // Event listener tombol "Gunakan"
    document.querySelectorAll('.btn-use-voucher').forEach(button => {
        button.addEventListener('click', function () {
            const code = this.getAttribute('data-code');
            copyKode(code); // opsional, copy kode voucher ke input voucher

            // Ubah tombol menjadi "Digunakan" dan nonaktifkan
            this.textContent = "Digunakan";
            this.disabled = true;
            this.classList.remove('btn-outline-success');
            this.classList.add('btn-success');

            // Jika ingin supaya hanya satu voucher yang bisa dipakai, matikan tombol lain
            document.querySelectorAll('.btn-use-voucher').forEach(btn => {
                if (btn !== this) {
                    btn.textContent = "Gunakan";
                    btn.disabled = false;
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-success');
                }
            });
        });
    });
</script>

</body>
</html>
