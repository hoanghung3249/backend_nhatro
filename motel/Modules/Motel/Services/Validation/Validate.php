<?php 
namespace Modules\Motel\Services\Validation;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;


class Validate extends Validator {

    public function validateCheckCmnd($attribute, $value, $parameters){
        //dd($parameters[2]);
        if(!isset($parameters[2])){

            $result = DB::table($parameters[0])->where(function($query) use ($attribute, $value, $parameters) {
                $query->whereRaw("cmnd = '$value'")->where('user_id',$parameters[1]);
            })->first();
        }else{
            $result = DB::table($parameters[0])->where(function($query) use ($attribute, $value, $parameters) {
                $query->whereRaw("cmnd = '$value'")->where('user_id',$parameters[1])->where('id','<>',$parameters[2]);
            })->first();
        }
        return $result ? false : true;          
    }
    public function validateCountCmnd($attribute, $value, $parameters){
        $value = preg_replace('/\s+/', '', $value);
        $value = strlen($value);
        $arr_cmnd = [9,12];
        $data = in_array($value, $arr_cmnd);
        if(!$data){
            return false;
        }return true;
    }
}