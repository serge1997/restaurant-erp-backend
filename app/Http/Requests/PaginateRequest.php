<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginateRequest extends FormRequest
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
            'search' => ['nullable'],
            'limit' => ['required'],
            'offset' => ['required']
        ];
    }


   public function __get($key)
   {
       if ($this->input($key) === "null") {
           return null;
       }
       if (is_array($this->input($key))) {
            $paramsKey = array_search(0, $this->input($key));
            if ($paramsKey !== false) {
                $newParams = $this->input($key);
                unset($newParams[$paramsKey]);
                return $newParams;
            }
       }
       return $this->input($key);
   }
}
