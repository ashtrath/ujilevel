@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Metode Pembayaran</h1>

    <form action="{{ route('admin.metode_pembayaran.update', $metodePembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Metode</label>
            <input type="text" name="nama" class="form-control" value="{{ $metodePembayaran->nama }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.metode_pembayaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
