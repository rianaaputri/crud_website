@extends('layouts.admin')

@section('content')
      <h3 class="mb-4">Daftar Produk</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.seller.show', $user->id) }}" class="btn btn-info btn-sm">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
