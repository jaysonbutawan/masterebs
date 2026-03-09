<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
        protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $table = 'order_items';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
