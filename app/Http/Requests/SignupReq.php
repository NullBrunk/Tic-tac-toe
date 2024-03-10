<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupReq extends FormRequest
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
            "email" => "required|email|max:50|unique:users",
            "name" => "required|max:50",
            "password" => "required",
            "password_confirmation" => "required|same:password"
        ];
    }
}
