<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'carts_items';

    protected $fillable = ['cart_id', 'produk_id', 'jumlah', 'harga_satuan'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function produk()
    {
        return $this->belongsTo(Product::class);
    }
}
