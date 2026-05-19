<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderTransfertRequest extends FormRequest
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
            "id"        => "required|integer",
            "table_id"  => "required|integer",
            "customer_name" => "nullable|string",
            "transfert_reason"  => "nullable|string",
            "items.*.menu_item_id" => "required|integer",
            "items.*.quantity" => "required|integer",
        ];
    }
}
