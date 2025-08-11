@extends('layouts.admin')

@section('content')
     
<div class="container">
    <h3>Daftar Customer</h3>

    @if($users->isEmpty())
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
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('admin.customer.show', $user->id) }}">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
