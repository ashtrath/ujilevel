@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Riwayat Transaksi</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>Rp {{ number_format($transaction->final_amount, 2) }}</td>
                        <td>{{ $transaction->paymentMethod->nama }}</td>
                        <td>Berhasil</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
