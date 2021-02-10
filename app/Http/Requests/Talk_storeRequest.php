<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Talk_storeRequest extends FormRequest
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
            'message' => 'string|max:500|nullable',
        ];
    }

    public function messages()
    {
        return [
            //
           'message.string' => '↓文字列で入力して下さい。',
           'message.max' => '↓500文字以内で入力して下さい。',
        ];
    }
}
