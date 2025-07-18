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
        <div class="mb-3">
            <label for="kode">Kode Voucher</label>
            <input type="text" name="kode" id="kode" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="jenis_diskon">Jenis Diskon</label>
            <select name="jenis_diskon" id="jenis_diskon" class="form-control" required>
                <option value="persen">Persentase (%)</option>
                <option value="nominal">Nominal (Rp)</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nilai_diskon">Nilai Diskon</label>
            <input type="number" name="nilai_diskon" id="nilai_diskon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="minimal_belanja">Minimal Belanja</label>
            <input type="number" name="minimal_belanja" id="minimal_belanja" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
            <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
