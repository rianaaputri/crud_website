@extends('layouts.admin') 

@section('content')
<div class="container mt-4">
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
                        <h5 class="card-title">{{ $voucher->kode }}</h5>
                        <p class="card-text">
                            Diskon:
                            @if($voucher->jenis_diskon == 'persen')
                                {{ $voucher->nilai_diskon }}%
                            @else
                                Rp {{ number_format($voucher->nilai_diskon, 0, ',', '.') }}
                            @endif
                            <br>
                            Min. Belanja: Rp {{ number_format($voucher->minimal_belanja, 0, ',', '.') }} <br>
                            Berlaku s/d: {{ \Carbon\Carbon::parse($voucher->tanggal_kadaluarsa)->format('d M Y') }}
                        </p>
                        @auth('customer')
                            <button class="btn btn-sm btn-outline-success" onclick="copyKode('{{ $voucher->kode }}')">Gunakan</button>
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
