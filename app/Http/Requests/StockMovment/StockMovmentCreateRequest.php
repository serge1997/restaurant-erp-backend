<?php

namespace App\Http\Requests\StockMovment;

use Illuminate\Foundation\Http\FormRequest;

class StockMovmentCreateRequest extends FormRequest
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
            "product_id"        => "required|integer",
            "quantity"          => "required|integer",
            "direction"         => "nullable|integer",
            "reference_type"    => "required|integer",
            "reference_id"      => "required_if:reference_type,1,2,4|integer|nullable",
            "cost"              => "required_if:reference_type,1|numeric",
            "supplier_id"       => "nullable|integer",
            "moved_at"          => "nullable|date",
            "description"       => "nullable|string"
        ];
    }
}
