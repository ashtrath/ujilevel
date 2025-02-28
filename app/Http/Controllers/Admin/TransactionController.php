<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('transactionItems.produk')->where('user_id', Auth::id())->get();
        return view('admin.transaction.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $cart = Cart::with('cartItems.produk')->where('user_id', Auth::id())->firstOrFail();

        if ($cart->cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $totalHarga = $cart->cartItems->sum(fn($item) => $item->jumlah * $item->harga_satuan);
        $finalAmount = $totalHarga;

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total_harga' => $totalHarga,
            'final_amount' => $finalAmount,
            'payment_method_id' => $request->payment_method_id,
        ]);

        foreach ($cart->cartItems as $cartItem) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'produk_id' => $cartItem->produk_id,
                'jumlah' => $cartItem->jumlah,
                'harga_satuan' => $cartItem->harga_satuan,
            ]);
        }

        $cart->cartItems()->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil!');
    }
}
