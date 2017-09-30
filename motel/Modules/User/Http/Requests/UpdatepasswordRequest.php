<?php

namespace Modules\User\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
//use Modules\Precise\Http\Requests\Api\ApiRequest;

class UpdatepasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'password.required' => 'Password must not be blank',
            'password_confirm.required' => 'Password confirm must not be blank',
            'password_confirm.same' =>'Password confirm is not match'

        ];
    }
}
