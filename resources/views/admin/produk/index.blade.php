@extends('layouts.admin')

@section('content')
      <h3 class="mb-4">Daftar Produk</h3>
    

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('/storage/products/' . $product->image) }}"
                         class="card-img-top"
                         style="object-fit: cover; height: 200px; border-radius: 5px 5px 0 0;"
                         alt="{{ $product->title }}">

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text">
                            <strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}<br>
                            <strong>Stok:</strong> {{ $product->stock }}
                        </p>
                    </div>

                    <div class="card-footer text-center bg-white border-top-0">
                        <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada produk tersedia.</p>
        @endforelse
    </div>
@endsection
