<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'user_name' => 'string|max:20|nullable',
            'age' => 'string|max:4|nullable',
            'elementaryTeam' => 'string|max:20|nullable',
            'juniorHighTeam' => 'string|max:20|nullable',
            'highTeam' => 'string|max:20|nullable',
            'universityTeam' => 'string|max:20|nullable',
            'introduction' => 'string|max:100|nullable',
        ];
    }

    public function messages()
    {
        return [
            //
           'user_name.string' => '↓文字列で入力して下さい。',
           'user_name.max' => '↓20文字以内で入力して下さい。',
           'age.string' => '↓整数で入力して下さい。',
           'age.max' => '↓4桁以内で入力して下さい。',
           'elementaryTeam.string' => '↓文字列で入力して下さい。',
           'elementaryTeam.max' => '↓20文字以内で入力して下さい。',
           'juniorHighTeam.string' => '↓文字列で入力して下さい。',
           'juniorHighTeam.max' => '↓20文字以内で入力して下さい。',
           'highTeam.string' => '↓文字列で入力して下さい。',
           'highTeam.max' => '↓20文字以内で入力して下さい。',
           'universityTeam.string' => '↓文字列で入力して下さい。',
           'universityTeam.max' => '↓20文字以内で入力して下さい。',
           'introduction.string' => '↓文字列で入力して下さい。',
           'introduction.max' => '↓100文字以内で入力して下さい。',
        ];
    }
}
