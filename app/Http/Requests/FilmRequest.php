<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
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
            'name'=>['string','required','max:150'],
			'country_id'=>['string','required'],
			'duration'=>['integer','required','min:5', 'max:300'],
			'year_of_issue'=>['integer','required', 'min:1850'],
            'age'=>['integer','required', 'min:0', 'max:21'],
			'link_img'=>['string','required'],
			'link_kinopoisk'=>['string','required'],
			'link_video'=>['string','required'],
            'category'
        ];
    }
}
