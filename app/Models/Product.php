<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'barcode',
        'product_base_price',
        'price',
        'quantity',
        'status',
        'category_name',
        'shelf',
        'client_id'
    ];
}
