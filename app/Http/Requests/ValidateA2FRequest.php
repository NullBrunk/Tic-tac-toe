<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateA2FRequest extends FormRequest
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
        $rule = "required|string|min:1|max:1";

        return [
            "totp1" => $rule,
            "totp2" => $rule,
            "totp3" => $rule,
            "totp4" => $rule,
            "totp5" => $rule,
            "totp6" => $rule,
        ];
    }
}
