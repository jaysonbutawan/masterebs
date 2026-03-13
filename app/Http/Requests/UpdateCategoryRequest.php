<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
       $id = $this->route('category');

        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a string.',
            'name.max' => 'Category name must not exceed 255 characters.',
            'name.unique' => 'Category name must be unique.',
            'description.string' => 'Description must be a string.',
            'description.max' => 'Description must not exceed 500 characters.',
        ];
    }
}
