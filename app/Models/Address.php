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

    protected $appends = ['full_address'];

    public function getFullAddressAttribute()
    {
        return $this->prefecture
             . $this->city
             . $this->street
             . $this->building;
    }
}
