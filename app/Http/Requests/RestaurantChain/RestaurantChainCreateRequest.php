<?php

namespace App\Http\Requests\RestaurantChain;

use App\Http\Requests\Address\AddressCreateRequest;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantChainCreateRequest extends FormRequest
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
        return array_merge(
            [
                "name"                          => "required|string|max:60",
                "corporate_name"                => "required|string|max:60",
                "cpf_cnpj"                      => "required|string|max:24",
                "phone"                         => "required|string|max:60",
                "comercial_contact"               => "nullable|string|max:60",
                "email"                         => "nullable|string|max:40",
                "account_responsable_phone"     => "required|string|max:60",
                "account_responsable_email"     => "nullable|string|max:40",
                "account_responsable_name"      => "required|string|max:60",
            ],
            AddressCreateRequest::capture()->rules()
        );
    }
}
