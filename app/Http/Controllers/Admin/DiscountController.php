<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();

        return view('admin.discount.index', compact('discounts'));
    }

    public function add()
    {
        return view('admin.discount.create');
    }

    public function store(StoreDiscountRequest $request)
    {
        Discount::create($request->validated());

        return redirect()->back()->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('admin.discount.edit', compact('discount'));
    }

    public function update(UpdateDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request->validated());

        return redirect()->route('discount.index')->with('success', 'Diskon berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('discount.index')->with('success', 'Diskon berhasil dihapus!');
    }
}
