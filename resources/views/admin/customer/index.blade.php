@extends('layouts.admin')

@section('content')
     
<div class="container">
    <h3>Daftar Customer</h3>

    @if($customers->isEmpty())
        <p>Tidak ada customer.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <a href="{{ route('admin.customer.show', $customer->id) }}">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
