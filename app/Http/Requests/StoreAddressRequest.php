<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'recipient_name' => 'required|string|max:255',
            'postal_code'    => 'required|string|max:7',
            'prefecture'     => 'required|string|max:255',
            'city'           => 'required|string|max:255',
            'street'         => 'required|string|max:255',
            'building'       => 'nullable|string|max:255',
            'phone_number'   => 'required|string|max:11',
            'is_default'     => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'recipient_name.required' => '受取人氏名を入力してください。',
            'recipient_name.string'   => '受取人氏名は文字列で入力してください。',
            'recipient_name.max'      => '受取人氏名は255文字以内で入力してください。',

            'postal_code.required' => '郵便番号を入力してください。',
            'postal_code.string'   => '郵便番号は文字列で入力してください。',
            'postal_code.max'      => '郵便番号は7文字以内で入力してください。',

            'prefecture.required' => '都道府県を入力してください。',
            'prefecture.string'   => '都道府県は文字列で入力してください。',
            'prefecture.max'      => '都道府県は255文字以内で入力してください。',

            'city.required' => '市区町村を入力してください。',
            'city.string'   => '市区町村は文字列で入力してください。',
            'city.max'      => '市区町村は255文字以内で入力してください。',

            'street.required' => '町名・番地を入力してください。',
            'street.string'   => '町名・番地は文字列で入力してください。',
            'street.max'      => '町名・番地は255文字以内で入力してください。',

            'building.string' => '建物名・部屋番号は文字列で入力してください。',
            'building.max'    => '建物名・部屋番号は255文字以内で入力してください。',

            'phone_number.required' => '電話番号を入力してください。',
            'phone_number.string'   => '電話番号は文字列で入力してください。',
            'phone_number.max'      => '電話番号は11文字以内で入力してください。',

            'is_default.boolean' => 'デフォルト住所の設定は真偽値で指定してください。',
        ];
    }
}
