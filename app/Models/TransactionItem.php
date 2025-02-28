<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transactions_items';

    protected $fillable = ['transaction_id', 'produk_id', 'jumlah', 'harga_satuan'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function produk()
    {
        return $this->belongsTo(Product::class);
    }
}
