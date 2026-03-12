<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'status' => 'nullable|boolean'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'price.required' => 'Product price is required.',
            'stock.required' => 'Product stock is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'status.boolean' => 'Product status must be a boolean value.',
        ];
    }
}
