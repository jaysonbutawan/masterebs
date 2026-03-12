<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.integer' => 'User ID must be an integer.',
            'user_id.exists' => 'User ID must exist in the users table.',
            'items.required' => 'Items are required.',
            'items.array' => 'Items must be an array.',
            'items.min' => 'At least one item is required.',
            'items.*.product_id.required' => 'Product ID is required for each item.',
            'items.*.product_id.integer' => 'Product ID must be an integer for each item.',
            'items.*.product_id.exists' => 'Product ID must exist in the products table for each item.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.integer' => 'Quantity must be an integer for each item.',
            'items.*.quantity.min' => 'Quantity must be at least 1 for each item.',
            'items.*.price.required' => 'Price is required for each item.',
            'items.*.price.numeric' => 'Price must be a number for each item.',
            'items.*.price.min' => 'Price must be at least 0 for each item.',  
        ];
            }
}
