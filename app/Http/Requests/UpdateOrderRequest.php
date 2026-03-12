<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Order;

class UpdateOrderRequest extends FormRequest
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
            'user_id' => 'sometimes|integer|exists:users,id',
            'total_amount' => 'sometimes|numeric|min:0',
            'status' => [
                'sometimes',
                'string',
                Rule::in([
                    Order::STATUS_PENDING,
                    Order::STATUS_COMPLETED,
                    Order::STATUS_CANCELLED,
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.integer' => 'User ID must be an integer.',
            'user_id.exists' => 'User ID must exist in the users table.',
            'total_amount.numeric' => 'Total amount must be a number.',
            'total_amount.min' => 'Total amount must be at least 0.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be one of: pending, completed, cancelled.',
        ];
    }
}
