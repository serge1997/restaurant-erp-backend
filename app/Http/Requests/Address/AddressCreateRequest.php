<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressCreateRequest extends FormRequest
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
            "address.cep"   => "required|string",
            "address.street"    => "required_with:address.cep",
            "address.number"    => "required_with:address.cep",
            "address.neighborhood"  => "required_with:address.cep",
            "address.city"  => "required_with:address.cep",
            "address.city_id"  => "nullable|string",
            "address.state" => "required_with:address.cep",
            "address.complement"    => "nullable|string|max:60",
        ];
    }
}
