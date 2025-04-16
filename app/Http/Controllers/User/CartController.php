<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with('cartItems.produk')->where('user_id', Auth::id())->first();
        $paymentMethods = PaymentMethod::all(); // Ambil metode pembayaran dari database

        return view('user.cart.index', compact('cart', 'paymentMethods'));
    }


    public function store(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'produk_id' => $request->produk_id,
            ],
            [
                'jumlah' => $request->jumlah,
                'harga_satuan' => Product::findOrFail($request->produk_id)->harga,
            ]
        );

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $product = Product::findOrFail($request->product_id);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('produk_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('jumlah', $request->quantity);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'produk_id' => $request->product_id,
                'jumlah' => $request->quantity,
                'harga_satuan' => $product->harga,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

}
