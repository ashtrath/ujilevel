<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:category,nama_kategori',
            'gambar_kategori' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('gambar_kategori')) {
            $validated['gambar_kategori'] = $request->file('gambar_kategori')->store('kategori', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:category,nama_kategori,' . $category->id,
            'gambar_kategori' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('gambar_kategori')) {
            if ($category->gambar_kategori) {
                Storage::disk('public')->delete($category->gambar_kategori);
            }
            $validated['gambar_kategori'] = $request->file('gambar_kategori')->store('kategori', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        if ($category->gambar_kategori) {
            Storage::disk('public')->delete($category->gambar_kategori);
        }
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus');
    }
}
