<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'message' => 'string|max:250',
        ];
    }

    public function messages()
    {
        return [
            //
           'message.string' => '↓文字列で入力して下さい。',
           'message.max' => '↓250文字以内で入力して下さい。',
        ];
    }




    protected function failedValidation(Validator $validator) {
        $response = response()->json([
            'status' => 400,
            'errors' => $validator->errors(),
            'statusText' => 'Failed validation.',
        ], 400);
        throw new HttpResponseException($response);
    }

    // protected function failedValidation(Validator $validator) {
    //     $response['status']  = 400;
    //     $response['statusText'] = 'Failed validation.';
    //     $response['errors']  = $validator->errors();
    //     throw new HttpResponseException(
    //         response()->json( $response, 400 )
    //     );
    // }


}
