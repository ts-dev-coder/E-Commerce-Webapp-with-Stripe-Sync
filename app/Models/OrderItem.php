<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'quantity',
        'subtotal',
        'order_id',
        'product_id'
    ];

    # TODO: Add relation definition
}
