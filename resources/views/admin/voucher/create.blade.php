@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Buat Voucher Baru</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.voucher.store') }}" method="POST">
        @csrf
        {{-- Kode Voucher --}}
        <div class="mb-3">
            <label for="code" class="form-label">Kode Voucher</label>
            <input type="text" name="code" id="code" class="form-control" required>
        </div>

        {{-- Nilai Diskon --}}
        <div class="mb-3">
            <label for="discount" class="form-label">Nilai Diskon</label>
            <input type="number" name="discount" id="discount" class="form-control" required>
            <small class="text-muted">Masukkan nilai diskon dalam angka. Gunakan persen atau nominal sesuai kebijakan.</small>
        </div>

        {{-- Tanggal Mulai Berlaku --}}
        <div class="mb-3">
            <label for="valid_from" class="form-label">Berlaku Dari</label>
            <input type="date" name="valid_from" id="valid_from" class="form-control">
        </div>

        {{-- Tanggal Kadaluarsa --}}
        <div class="mb-3">
            <label for="valid_until" class="form-label">Berlaku Sampai</label>
            <input type="date" name="valid_until" id="valid_until" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
