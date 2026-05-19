<?php

namespace App\Http\Requests\MenuItem;


use Illuminate\Foundation\Http\FormRequest;

class MenuItemUpdateRequest extends FormRequest
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
        return array_merge([
            "id"                            => "required|integer",
            "sheet.*.id"                    => "nullable|integer",
            "sheet.*.product_id"            => "nullable|integer",
            "sheet.*.quantity"              => "nullable|integer"
        ],
            MenuItemCreateRequest::capture()->rules()
        );
    }

    public function getSheet(): array
    {
        return !empty($this->sheet) ? $this->sheet : [];
    }
}
