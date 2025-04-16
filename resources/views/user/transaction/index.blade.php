@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Checkout / Buat Transaksi</h1>

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="alert alert-warning" role="alert">
                Keranjang belanja Anda kosong. Silakan <a href="{{ route('some.product.page') }}">tambahkan produk</a>
                terlebih dahulu.
            </div>
            <a href="{{ route('cart.index') }}" class="btn btn-secondary mt-3">Kembali ke Keranjang</a>
        @else
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf

                <h4 class="mb-3">Ringkasan Pesanan</h4>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">Nama Produk</th>
                            <th scope="col" class="text-end">Harga Satuan</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $subTotal = 0;
                        @endphp

                        @foreach ($cartItems as $item)
                            @php
                                $product = $item->product;
                                if (!$product) {
                                    continue;
                                }
                                $lineTotal = $product->harga * $item->quantity;
                                $subTotal += $lineTotal;
                            @endphp
                            <tr>
                                <td>{{ $product->nama_produk }}</td>
                                <td class="text-end">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Total Belanja:</th>
                            <th class="text-end">Rp {{ number_format($subTotal, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end h5">Grand Total:</th>
                            <th class="text-end h5">
                                Rp {{ number_format($subTotal, 0, ',', '.') }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <h4 class="mb-3">Pilih Metode Pembayaran</h4>
                <div class="mb-4">
                    <label for="payment_method_id" class="form-label visually-hidden">
                        Metode Pembayaran
                    </label>
                    <select name="payment_method_id" id="payment_method_id"
                            class="form-select @error('payment_method_id') is-invalid @enderror" required>
                        <option value="" disabled {{ old('payment_method_id') ? '' : 'selected' }}>
                            -- Pilih Metode Pembayaran --
                        </option>
                        @forelse ($metodePembayaran as $metode)
                            <option
                                value="{{ $metode->id }}" {{ old('payment_method_id') == $metode->id ? 'selected' : '' }}>
                                {{ $metode->nama }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada metode pembayaran yang tersedia saat ini.</option>
                        @endforelse
                    </select>
                    @error('payment_method_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Keranjang
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Proses Transaksi
                    </button>
                </div>
            </form>
        @endif

    </div>
@endsection
