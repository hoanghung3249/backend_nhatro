<?php

namespace Modules\Motel\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCustomerRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'full_name' => 'required',
            'dob' => 'required',
            'cmnd' => 'required|numeric',
            'phone' => 'required|numeric',
            'email' => 'email',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Họ tên không được bỏ trống',

            'dob.required' => 'Ngày sinh không được bỏ trống',
            'cmnd.required' => 'Chứng minh nhân dân không được bỏ trống',
            'cmnd.numeric' => 'Chứng minh nhân dân phải là kiểu số',

            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.numeric' => 'Số điện thoại phải là kiểu số',
            'email.email' => 'Email không đúng định dạng',
        ];
    }
}