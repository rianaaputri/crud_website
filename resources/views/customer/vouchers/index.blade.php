{{-- resources/views/customer/vouchers/index.blade.php --}}
@extends('layouts.customer')

@section('content')
<div class="container mt-4">
    <h4>Voucher Tersedia</h4>
    <div class="row">
        @foreach($vouchers as $voucher)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>{{ $voucher->code }}</h5>
                    <p>
                        Diskon: {{ $voucher->discount }}% <br>
                        Berlaku s/d: {{ $voucher->valid_until }}
                    </p>
                    <button class="btn btn-sm btn-outline-primary" onclick="copyKode('{{ $voucher->code }}')">Salin Kode</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function copyKode(kode) {
    navigator.clipboard.writeText(kode);
    alert("Kode voucher '" + kode + "' disalin!");
}
</script>
@endsection
