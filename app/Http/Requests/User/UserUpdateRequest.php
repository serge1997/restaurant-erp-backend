<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            ...UserCreateRequest::capture()->rules(),
            "id"    => "required|integer",
            "address.cep"   => "required|string",
            "address.street"    => "required|string",
            "address.number"    => "required|numeric",
            "address.neighborhood"  => "required|string",
            "address.city"  => "required|string",
            "address.state" => "required|string",
            "address.complement"    => "nullable|string|max:60",
        ];
    }
}
