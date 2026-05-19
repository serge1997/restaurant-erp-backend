<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Address\AddressCreateRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name'  => 'required|string|max:60',
            'username'  => 'required|string|max:60',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'cpf'   => 'required|string|max:14|',
            'is_active' => 'boolean',
            'gender'    => 'required|string|in:M,F,O',
            'birth_date'    => 'nullable|date',
            'roles'         => 'required|array',
            'permissions'   => 'nullable|array',
            ...AddressCreateRequest::capture()->rules()
        ];
    }
}
