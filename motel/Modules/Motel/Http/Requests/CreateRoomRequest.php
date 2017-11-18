<?php

namespace Modules\Motel\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRoomRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'erea' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'payment_on_electricity' => 'required|numeric',
            'payment_of_water' => 'required|numeric',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên phòng không được bỏ trống',

            'erea.required' => 'Diện tích không được bỏ trống',
            'erea.numeric' => 'Diện tích phải là kiểu số',

            'unit_price.required' => 'Giá phòng không được bỏ trống',
            'unit_price.numeric' => 'Giá phòng phải là kiểu số',

            'payment_on_electricity.required' => 'Tiền điện không được bỏ trống',
            'payment_on_electricity.numeric' => 'Tiền điện phải là kiểu số',

            'payment_of_water.required' => 'Tiền nước không được bỏ trống',
            'payment_of_water.numeric' => 'Tiền nước phải là kiểu số',
        ];
    }
}
