<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StoreCartRequest extends FormRequest
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
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'required|int|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'The product ID is required.',
            'product_id.int' => 'The product ID must be an integer.',
            'product_id.exists' => 'The selected product does not exist.',

            'quantity.required' => 'The quantity is required.',
            'quantity.int' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
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
