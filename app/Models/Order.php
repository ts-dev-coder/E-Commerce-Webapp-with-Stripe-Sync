<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'status',
        'total_price',
        'shipping_fee',
        'recipient_name',
        'postal_code',
        'phone_number',
        'ordered_at',
        'paid_at',
        'shipped_at',
        'address_id',
        'user_id'
    ];

    # TODO: Add relation definition
}
