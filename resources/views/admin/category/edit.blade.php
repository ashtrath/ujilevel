@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Kategori</h1>
        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="{{ $category->nama_kategori }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Kategori</label>
                <input type="file" name="gambar_kategori" class="form-control">
                @if ($category->gambar_kategori)
                    <img src="{{ asset('storage/' . $category->gambar_kategori) }}" width="100" alt="Gambar Kategori">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
