<?php

namespace App\Rules;

use App\Models\Product;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxPurchaseLimit implements ValidationRule
{
    protected int $productId;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($this->productId);

        if(!$product) {
            $fail('Product not found.');
            return;
        }

        if($value > $product->max_quantity) {
            $fail("You can only purchase up to {$product->max_quantity} of this product.");
        }
    }
}
