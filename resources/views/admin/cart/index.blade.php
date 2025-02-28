@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Keranjang Belanja</h2>
        @if ($cart && $cart->cartItems->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->cartItems as $item)
                        <tr>
                            <td>{{ $item->produk->nama_produk }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->harga_satuan, 2) }}</td>
                            <td>Rp {{ number_format($item->jumlah * $item->harga_satuan, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Form Checkout dengan Pilihan Metode Pembayaran -->
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="payment_method_id" class="form-label">Pilih Metode Pembayaran:</label>
                    <select name="payment_method_id" id="payment_method_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        @else
            <p>Keranjang Anda kosong.</p>
        @endif
    </div>
@endsection
