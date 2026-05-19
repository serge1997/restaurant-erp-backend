<?php

namespace App\Http\Requests\Table;

use Illuminate\Foundation\Http\FormRequest;

class TableCreateRequest extends FormRequest
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
            "number" => "required|integer",
            "capacity"  => "required|integer",
            "name"      => "nullable|string|max:15",
            "room_id"   => "required|integer",
            "is_active"    => "required|boolean",
            "shape"     => "nullable|string"
        ];
    }
}
