<?php

namespace Modules\Motel\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\User\Contracts\Authentication;

class UpdateCustomerRequest extends BaseFormRequest
{

    private $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();

        $this->auth = $auth;
    }
    public function rules()
    {
        $currentUser = $this->auth->user()->id;
        $userId = $this->route()->parameter('id');
        return [
            'full_name' => 'required',
            'cmnd' => "required|numeric|check_cmnd:customer,{$currentUser},{$userId}|count_cmnd",
            'phone' => 'required|numeric',
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

            'cmnd.required' => 'Chứng minh nhân dân không được bỏ trống',
            'cmnd.numeric' => 'Chứng minh nhân dân phải là kiểu số',

            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.numeric' => 'Số điện thoại phải là kiểu số',

            'cmnd.check_cmnd' => 'Số chứng minh nhân dân đã tồn tại trong hệ thống',
            'cmnd.count_cmnd' => 'Số chứng minh nhân dân không đúng định dạng'
        ];
    }
}