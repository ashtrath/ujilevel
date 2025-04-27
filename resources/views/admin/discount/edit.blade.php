@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Data Diskon</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kode Promo</th>
                    <th>Tipe</th>
                    <th>Jumlah Diskon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts as $discount)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $discount->name }}</td>
                    <td>{{ $discount->promo_code }}</td>
                    <td>{{ $discount->type }}</td>
                    <td>{{ $discount->discount_amount }}</td>
                    <td>
                        @if ($discount->status === 'Draft')
                            <span class="badge bg-warning text-dark">Draft</span>
                        @elseif ($discount->status === 'Public')
                            <span class="badge bg-success">Public</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('discounts.edit', $discount->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus diskon ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection