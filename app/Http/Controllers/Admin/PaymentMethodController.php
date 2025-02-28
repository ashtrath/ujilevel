<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $metodePembayaran = PaymentMethod::paginate(10);
        return view('admin.payment_methods.index', compact('metodePembayaran'));
    }

    public function create()
    {
        return view('admin.payment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:payment_methods,nama|max:255'
        ]);

        PaymentMethod::create($request->only('nama'));

        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'nama' => 'required|unique:payment_methods,nama,' . $paymentMethod->id . '|max:255'
        ]);

        $paymentMethod->update($request->only('nama'));

        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
