<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            "name" => 'string|required|max:60',
            "description" => 'string|nullable|max:160',
            "category_id" => 'integer|required',
            "cost" => 'numeric|nullable',
            //"unit_contain" => 'numeric|nullable',
            "min_quantity" => 'integer|nullable',
            "is_active" => 'boolean'
        ];
    }
}
