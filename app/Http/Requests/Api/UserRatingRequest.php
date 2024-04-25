<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRatingRequest extends FormRequest
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
            'film_id' => ['required'],
            'ball' => ['required', 'integer', 'min:1', 'max:5'],
            'user_id' => ['required'],
        ];
    }
    protected function prepareForValidation(): void {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
}
