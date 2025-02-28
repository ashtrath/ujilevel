@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Kategori</h1>
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Tambah Kategori</a>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->nama_kategori }}</td>
                        <td>
                            @if ($category->gambar_kategori)
                                <img src="{{ asset('storage/' . $category->gambar_kategori) }}" width="100" alt="Gambar Kategori">
                            @else
                                Tidak ada gambar
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
@endsection
