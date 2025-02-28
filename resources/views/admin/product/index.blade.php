@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Produk</h1>
        <a href="{{ route('admin.product.create') }}" class="btn btn-primary">Tambah Produk</a>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->nama_produk }}</td>
                        <td>{{ $product->category->nama_kategori }}</td>
                        <td>Rp {{ number_format($product->harga, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" value="1" min="1"
                                    class="form-control d-inline w-25">
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
@endsection
