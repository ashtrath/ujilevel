@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Metode Pembayaran</h1>
    <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-primary">Tambah Metode Pembayaran</a>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Metode</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($metodePembayaran as $metode)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $metode->nama }}</td>
                    <td>
                        <a href="{{ route('admin.payment_methods.edit', $metode->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.payment_methods.destroy', $metode->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus metode ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $metodePembayaran->links() }}
</div>
@endsection
