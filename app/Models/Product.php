<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'is_published',
        'published_at', 
        'max_quantity',
        'stripe_id',
        'stripe_price_id',
        'currency',
        'is_physical',
        'creator',
        'seo_title',
        'seo_description',
        'deleted_at'
    ];

    # TODO: Add relation definition
    public function categories() {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    
}
