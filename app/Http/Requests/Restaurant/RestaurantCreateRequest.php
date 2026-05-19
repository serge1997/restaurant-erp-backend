<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantCreateRequest extends FormRequest
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
            'name'                      => 'required|string|max:60',
            'corporate_name'            => 'required|string|max:60', //razao social
            'description'               => 'required|string|max:130',
            'address'                   => 'required|string|max:100',
            'number'                    => 'required|integer',
            'phone'                     => 'required|string|max:60',
            'email'                     => 'required|string|max:40',
            'corporate_registration'    => 'required|string|max:20', //cpf cnpj
            'loss_margim'               => 'numeric|nullable',
            'fix_margim'                => 'numeric|nullable',
            'variable_margim'           => 'numeric|nullable',
            'enable_tecnhical_sheet'    => 'boolean',
            'latitude'                  => 'numeric|nullable',
            'longitude'                 => 'numeric|nullable'
        ];
    }
}
