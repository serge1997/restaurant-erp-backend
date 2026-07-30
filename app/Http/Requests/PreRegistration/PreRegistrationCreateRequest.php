<?php

namespace App\Http\Requests\PreRegistration;

use App\Http\Requests\Address\AddressCreateRequest;
use Illuminate\Foundation\Http\FormRequest;

class PreRegistrationCreateRequest extends FormRequest
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
            'name'                                          => 'required',
            'corporate_name'                                => 'required',
            'cnpj'                                          => 'required',
            'phone'                                         => 'nullable|string',
            'comercial_contact'                             => 'required|string',
            'email'                                         => 'nullable',
            'account_responsable_phone'                     => 'required',
            'account_responsable_email'                     => 'required',
            'account_responsable_name'                      => 'required',
            'account_responsable_cpf'                       => 'required',
            'is_chain'                                      => 'required',
            "account_responsable_address.cep"               => "nullable|string",
            "account_responsable_address.street"            => "required_with:account_responsable_address.cep",
            "account_responsable_address.number"            => "required_with:account_responsable_address.cep",
            "account_responsable_address.neighborhood"      => "required_with:account_responsable_address.cep",
            "account_responsable_address.city_id"           => "required_with:account_responsable_address.cep",
            "account_responsable_address.state"             => "required_with:account_responsable_address.cep",
            "account_responsable_address.complement"        => "nullable|string|max:60",
            ...AddressCreateRequest::capture()->rules()

        ];
    }

    public function cnpj()
    {
        return removeMasks($this->input('cnpj'));
    }

    public function accountResponsableCpf()
    {
        return removeMasks($this->input('account_responsable_cpf'));
    }
}
