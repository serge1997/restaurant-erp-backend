<?php

namespace App\Http\Requests;

class StockMovmentPaginateRequest extends PaginateRequest
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
            PaginateRequest::capture()->rules(),
            [
                "products"  => "nullable|string"
            ]
        );
    }

    public function products(): array|null 
    {
        if ($this->products) {
            return explode(",", $this->products);
        }
        return null;
    }
}
