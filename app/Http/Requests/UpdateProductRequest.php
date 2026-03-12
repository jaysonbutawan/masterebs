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
    public function messages()
    {
        return [
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }
}
