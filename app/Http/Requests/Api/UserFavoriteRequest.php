<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserFavoriteRequest extends FormRequest
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
            'film_id' => ['required', 'integer', 'exists:films,id'],
            'like' => ['required', 'integer'],
            'user_id' => ['required', 'integer']
        ];
    }
    protected function prepareForValidation(): void {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
    
}
