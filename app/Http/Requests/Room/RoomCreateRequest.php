<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomCreateRequest extends FormRequest
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
            "name"          => "required|max:30|string",
            "description"   => "nullable|max:200|string",
            "capacity"      => "required|integer",
            "severity"      => "required|string",
            "icon"          => "required|string",
            "is_active"        => "boolean|required",
            "room_type_id"  => "required|integer"
        ];
    }
}
