<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'fio' => ['string', 'required', 'max:255'],
            'email' => ['string', 'required', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'required', 'min:6'],
            'birthday' => ['nullable', 'date'],
            'gender_id' => ['integer', 'required', 'exists:genders,id'],
        ];
    }
}
