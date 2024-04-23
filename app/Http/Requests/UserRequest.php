<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'id' => ['integer', 'required'],
            'fio' => ['string', 'required', 'max:255'],
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'min:6'],
            'birthday' => ['date', 'required'],
            'gender_id' => ['integer', 'required'],
            'created_at' => ['date', 'required'],
            'updated_at' => ['date', 'required'],
            'deleted_at' => ['date', 'nullable']
        ];
    }
}
