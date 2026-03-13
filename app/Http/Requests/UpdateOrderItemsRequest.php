<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemsRequest extends FormRequest
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
            'order_id' => 'sometimes|integer|exists:orders,id',
            'product_id' => 'sometimes|integer|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.integer' => 'Order ID must be an integer.',
            'order_id.exists' => 'Order ID must exist in the orders table.',
            'product_id.integer' => 'Product ID must be an integer.',
            'product_id.exists' => 'Product ID must exist in the products table.',
            'quantity.integer' => 'Quantity must be an integer.',
            'quantity.min' => 'Quantity must be at least 1.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price must be at least 0.'
        ];
    }
}
