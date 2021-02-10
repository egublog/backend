<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            //
           'image.required' => '必ず入力して下さい。',
           'image.file' => 'ファイルを入力して下さい。',
           'image.image' => 'イメージファイルを入力して下さい。',
           'image.mimes' => 'jpeg,png,jpg,gifのいずれかのタイプのファイルを入力して下さい。',
           'image.max' => '2048よりの小さい値で入力して下さい。',
        ];
    }
}
