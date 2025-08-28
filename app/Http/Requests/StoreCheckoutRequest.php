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
            'delivery_address_id' => ['required', 'int', 'exists:addresses,id']
        ]; 
    }

    public function messages(): array
    {
        return [
            'delivery_address_id.required' => 'Delivery Address ID is required.',
            'delivery_address_id.int' => 'Delivery Address ID must be an integer.',
            'delivery_address_id.exists' => 'The selected delivery address does not exists.',
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
