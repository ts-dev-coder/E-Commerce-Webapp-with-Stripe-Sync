<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;


class StoreCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Cart (array of products)
            'cart' => ['required', 'array', 'min:1'],
            'cart.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'cart.*.quantity' => ['required', 'integer', 'min:1'],

            // Address 
            'use_saved_address' => ['required', 'boolean'],
            'address_id' => ['required_if:use_saved_address,true', 'integer', 'exists:addresses,id'],

            'shipping.postal_code' => [
                'required_if:use_saved_address,false',
                'regex:/^\d{3}-\d{4}$/'
            ],
            'shipping.prefecture' => [
                'required_if:use_saved_address,false',
                'string',
                'max:20'
            ],
            'shipping.city' => [
                'required_if:use_saved_address,false',
                'string',
                'max:50'
            ],
            'shipping.street' => [
                'required_if:use_saved_address,false',
                'string',
                'max:100'
            ],
            'shipping.building' => [
                'nullable',
                'string',
                'max:100'
            ],
            'shipping.recipient_name' => [
                'required_if:use_saved_address,false',
                'string',
                'max:100'
            ],
            'shipping.phone_number' => [
                'required_if:use_saved_address,false',
                'regex:/^0\d{1,4}-\d{1,4}-\d{4}$/'
            ],
            'payment_method' => [
                'required',
                'in:stripe'
            ]
        ]; 
    }

    public function messages(): array
    {
        return [
            'cart.required' => 'The cart is required.',
            'cart.array' => 'The cart must be an array.',
            'cart.min' => 'The cart must contain at least one product.',
            'cart.*.product_id.required' => 'The product ID is required.',
            'cart.*.product_id.integer' => 'The product ID must be an integer.',
            'cart.*.product_id.exists' => 'The selected product does not exist.',
            'cart.*.quantity.required' => 'The quantity is required.',
            'cart.*.quantity.integer' => 'The quantity must be an integer.',
            'cart.*.quantity.min' => 'The quantity must be at least 1.',

            'use_saved_address.required' => 'Please specify whether to use a saved address.',
            'use_saved_address.boolean' => 'The saved address selection must be true or false.',

            'address_id.required_if' => 'Please select a saved address when using one.',
            'address_id.integer' => 'The address ID must be an integer.',
            'address_id.exists' => 'The selected address does not exist.',

            'shipping.postal_code.required_if' => 'The postal code is required when not using a saved address.',
            'shipping.postal_code.regex' => 'The postal code format must be 123-4567.',

            'shipping.prefecture.required_if' => 'The prefecture is required when not using a saved address.',
            'shipping.prefecture.string' => 'The prefecture must be a valid string.',
            'shipping.prefecture.max' => 'The prefecture may not be greater than 20 characters.',

            'shipping.city.required_if' => 'The city is required when not using a saved address.',
            'shipping.city.string' => 'The city must be a valid string.',
            'shipping.city.max' => 'The city may not be greater than 50 characters.',

            'shipping.street.required_if' => 'The street address is required when not using a saved address.',
            'shipping.street.string' => 'The street must be a valid string.',
            'shipping.street.max' => 'The street may not be greater than 100 characters.',

            'shipping.building.string' => 'The building name must be a valid string.',
            'shipping.building.max' => 'The building name may not be greater than 100 characters.',

            'shipping.recipient_name.required_if' => 'The recipient name is required when not using a saved address.',
            'shipping.recipient_name.string' => 'The recipient name must be a valid string.',
            'shipping.recipient_name.max' => 'The recipient name may not be greater than 100 characters.',

            'shipping.phone_number.required_if' => 'The phone number is required when not using a saved address.',
            'shipping.phone_number.regex' => 'The phone number format must be 0X-XXXX-XXXX.',

            'payment_method.required' => 'The payment method is required.',
            'payment_method.in' => 'The selected payment method is invalid. Only "stripe" is allowed.',
        ];
    }

    /**
     * Log the detail error info on the server.
     * Return an abstract error message to the frontend
     */
    protected function failedValidation(Validator $validator)
    {
        Log::warning('Cart validation failed', [
            'url' => request()->fullUrl(),
            'user_id' => auth()->id(),
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all()
        ]);

        throw new HttpResponseException(response()->json([
            'message' => 'An error occurred. Please try again.'
        ], 422));
    }
}
