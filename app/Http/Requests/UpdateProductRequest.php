<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'category_id' => 'sometimes|integer|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.integer' => 'Category ID must be an integer.',
            'category_id.exists' => 'Category ID must exist in the categories table.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',
            'description.string' => 'Description must be a string.',
            'description.max' => 'Description must not exceed 500 characters.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price must be at least 0.',
            'stock.integer' => 'Stock must be an integer.',
            'stock.min' => 'Stock must be at least 1.'
        ];
    }
}
