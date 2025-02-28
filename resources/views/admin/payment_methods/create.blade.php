@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Metode Pembayaran</h1>

    <form action="{{ route('admin.payment_methods.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Metode</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
