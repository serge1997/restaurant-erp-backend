<?php

namespace App\Http\Requests\PreRegistration;

use Illuminate\Foundation\Http\FormRequest;

class PreRegistrationConfirmRequest extends FormRequest
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
            'id'                    => 'required',
            'password'              => 'confirmed|string',
            'password_confirmation' => 'required|string',
            'gender'                => 'required|string'
        ];
    }
}
