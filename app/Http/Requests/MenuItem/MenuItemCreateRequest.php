<?php

namespace App\Http\Requests\MenuItem;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemCreateRequest extends FormRequest
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
            "name"                          =>  "required|max:40|string",
            "description"                   => "required|string|max:250",
            "category_id"                   => "required|integer",
            "price"                         => "required|numeric",
            "enable_technical_sheet"        => "required|string",
            "is_active"                     => "required|string",
            "cooking_time"                  => "nullable|string",
            "for_quantity_of_person"        => "nullable|integer",
            "promotional_price"             => "nullable|numeric",    
            "featured_types"                => "nullable|string",
            "image"                         => "nullable|file|mimes:jpg,png,jpeg",
        ];
    }
}
