<?php
namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderCancelItemRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "id"    => "required|integer",
            "item_id"   => "required|integer",
            "quantity"  => "required|integer",
            "reason"    => "required|integer",
            "observation"   => "nullable|string|required_if:reason,6",
            "restock" => "boolean"
        ];
    }
}