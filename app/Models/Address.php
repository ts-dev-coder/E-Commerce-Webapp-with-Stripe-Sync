<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_name',
        'postal_code',
        'prefecture',
        'city',
        'street',
        'building',
        'phone_number',
        'is_default',
        'user_id'
    ];

    # TODO: Add relation definition
}
