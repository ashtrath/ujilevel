@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Checkout</h1>
        <form action="{{ route('admin.transaction.store') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $cart)
                        <tr>
                            <td>{{ $cart->product->nama_produk }}</td>
                            <td>Rp {{ number_format($cart->product->harga, 0, ',', '.') }}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>Rp {{ number_format($cart->product->harga * $cart->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran_id" class="form-control" required>
                    @foreach ($metodePembayaran as $metode)
                        <option value="{{ $metode->id }}">{{ $metode->nama }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Proses Transaksi</button>
            <a href="{{ route('admin.cart.index') }}" class="btn btn-secondary">Kembali ke Keranjang</a>
        </form>
    </div>
@endsection
