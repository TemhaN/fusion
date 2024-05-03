<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserLikeReviewRequest extends FormRequest
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
            'user_id' => ['required', 'integer'],
            'review_id' => ['nullable', 'integer', 'exists:reviews,id'],
            'like' => ['required', 'integer'],
        ];
    }
    protected function prepareForValidation(): void {
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
}