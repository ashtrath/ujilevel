<?php

namespace App\Http\Controllers\User;

use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $userId = Auth::id();
        $cart = Cart::with('cartItems.produk')->where('user_id',
            $userId)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong atau tidak ditemukan!');
        }

        try {
            DB::beginTransaction();

            $totalHarga = $cart->cartItems->sum(fn($item) => $item->jumlah * $item->harga_satuan);
            $finalAmount = $totalHarga;

            $transaction = Transaction::create([
                'user_id' => $userId,
                'total_harga' => $totalHarga,
                'final_amount' => $finalAmount,
                'payment_method_id' => $request->payment_method_id,
                'status' => TransactionStatus::PROCESSING->value,
            ]);

            foreach ($cart->cartItems as $cartItem) {
                if (!$cartItem->produk) {
                    throw new Exception("Produk dengan ID {$cartItem->produk_id} tidak ditemukan di keranjang.");
                }
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'produk_id' => $cartItem->produk_id,
                    'jumlah' => $cartItem->jumlah,
                    'harga_satuan' => $cartItem->harga_satuan,
                ]);
            }

            $cart->cartItems()->delete();
            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Transaction creation failed: '.$e->getMessage());
            return back()->with('error',
                'Gagal membuat transaksi. Silakan coba lagi. Error: '.$e->getMessage()); // Optionally show error details in dev mode
        }
    }
}
