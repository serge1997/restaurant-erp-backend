<?php

namespace App\Http\Requests\PurchaseRequisition;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequisitionUpdateRequest extends FormRequest
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
            "id"    => "required|integer",
            "department_id" => "nullable|integer",
            "expected_delivery_date" => "nullable|date",
            "observation"           => "nullable|string|max:160",
            "items.*.id" => "nullable|integer",
            "items.*.product_id" => "required|integer",
            "items.*.ordered_quantity" => "required|integer",
            "items.*.unit_size" => "nullable|integer",
            "items.*.unit_of_measure" => "nullable|string"
        ];
    }
}
