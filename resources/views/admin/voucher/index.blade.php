@extends('layouts.admin') 

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Voucher</h4>
        <a href="{{ route('admin.voucher.create') }}" class="btn btn-primary">+ Buat Voucher</a>
    </div>

    <div class="row">
        @forelse($vouchers as $voucher)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $voucher->code }}</h5>
                        <p class="card-text">
                            Diskon: {{ $voucher->discount }} <br>
                            Berlaku dari: 
                            {{ $voucher->valid_from ? \Carbon\Carbon::parse($voucher->valid_from)->format('d M Y') : '-' }} <br>
                            Berlaku sampai: 
                            {{ $voucher->valid_until ? \Carbon\Carbon::parse($voucher->valid_until)->format('d M Y') : '-' }}
                        </p>

                        @auth('customer')
                            <button class="btn btn-sm btn-outline-success" onclick="copyKode('{{ $voucher->code }}')">Gunakan</button>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada voucher tersedia.</p>
        @endforelse
    </div>
</div>

<script>
    function copyKode(kode) {
        navigator.clipboard.writeText(kode);
        alert("Kode voucher '" + kode + "' disalin!");
    }
</script>
@endsection
