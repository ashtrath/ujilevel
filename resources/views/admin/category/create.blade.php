@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Kategori</h1>
        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Kategori</label>
                <input type="file" name="gambar_kategori" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
