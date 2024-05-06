<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable =[
        'price',
        'quantity',
        'product_id',
        'order_id',
        'product_base_price',
        'rebate_value',
        'profit',
        'price_single',
        'product_base_price_single',
        'transaction_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
