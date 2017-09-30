<?php

namespace Modules\Motel\Repositories\Eloquent;

use Modules\Motel\Repositories\MotelRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Http\Request;
use Modules\User\Entities\Sentinel\User;
use Modules\User\Entities\Sentinel\UserAPI;
use Auth;
use Hash;
use Illuminate\Http\Response;
use Mail;
use Carbon\Carbon;
use DB;

class EloquentMotelRepository extends EloquentBaseRepository implements MotelRepository
{
	public function SendMailAgain(){
		$user = Auth::guard('api')->user();
		$token = str_random(40);
		$user->remember_token = $token;
        $datetime = Carbon::now();
       	$user->exist_time = $datetime;
        $user->save();
        Mail::send('user::sentemail.register', ['user'=>$user , 'token' => $token], function ($message) use($user)
        {
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $message->to($user->email,$user->fist_name);
            //$message->bcc(env('MAIL_BCC'));
            $message->subject('Welcome to Services Solution');
        });
        return true;
		//return $user;
	}
	public function getUpdateRoles(){
		$user = Auth::guard('api')->user();
		$user_find = User::find($user->id);

				//return $user;
		$data = [];
		if($user->active == 0){
			return $data = [
				'code'=> 201
			];
			
		}else{
			$user_find->roles()->detach();
			$user_find->roles()->attach(1);
			$data_user = DB::table(DB::raw('users as u'))
					->selectRaw("
						u.first_name,
						u.last_name,
						u.email,
						u.phone,
						u.address,
						u.gender,
						u.avatar,
						u.active,
						ru.role_id
						")
				->join(DB::raw("role_users AS ru"),function($join){
					$join->on("ru.user_id","=","u.id");
				})
				->join(DB::raw("roles AS rs"),function($join){
					$join->on("rs.id","=","ru.role_id");
				})
				->where('u.id',$user->id)->get();
			return $data = [
				'code'=> 200,
				'data'=> $data_user
			];
		}
	}
}
