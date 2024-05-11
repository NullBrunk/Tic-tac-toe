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
        return [
            "totp1" => "required|string|min:1|max:1",
            "totp2" => "required|string|min:1|max:1",
            "totp3" => "required|string|min:1|max:1",
            "totp4" => "required|string|min:1|max:1",
            "totp5" => "required|string|min:1|max:1",
            "totp6" => "required|string|min:1|max:1",
        ];
    }
}
