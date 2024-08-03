<?php

namespace App\Http\Requests\ProductTrasaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductTransactionRequest extends FormRequest
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
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'required|string|max:65535',
            'post_code' => 'required|integer',
            'phone_number' => 'required|integer',
        ];
    }
}
