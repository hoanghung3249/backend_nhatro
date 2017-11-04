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
use File;
use Modules\User\Entities\Activation;
use Modules\Motel\Entities\News;

class EloquentMotelRepository extends EloquentBaseRepository implements MotelRepository
{
 	public function updateImageProfile($file)
    {
        $url = [];
        $filepathLocal = "";
        // $file = $request->file('picture');
        if(isset($file) && !empty($file))
        {
            $filename = date("Ymdhis") . "_" . $file->getClientOriginalName();
            //$tail  = $file->getClientOriginalExtension();
            $filepath = public_path('assets/media');
            // $img = \Image::make($file);
            // $img->resize(50,50);
            \Image::make($file->getRealPath())->resize(200, 200)->save("$filepath/$filename");
            // if($file->move($filepath, $filename))
            // {
                //$filepathLocal = $filepath . "/" . $filename;

            //    $url = S3::uploadFile($filepathLocal,$filename);
            // }
        }
        // if($filepathLocal){
        //     @unlink($filepathLocal);
        // }

       return $filename;
    }
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

				//return $user_find;
		$data = [];
		if($user->active == 0){
			return $data = [
				'code'=> 201
			];
			
		}else{
			$user_find->getRoleUser()->detach();
			$user_find->getRoleUser()->attach(1);

			$user_find->total_motel = env('TOTAL_MOTEL',2);
			$user_find->save();

			$activation = Activation::where('user_id',$user_find->id)->first();
            $activation->completed = 1;
            $activation->completed_at = Carbon::now();
            $activation->save();
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
	public function postUpdateProfile($data){
		$user = Auth::guard('api')->user();
		$user_check = User::find($user->id);
		if($user_check){
			$user_check->phone = $data['phone'];
			$user_check->first_name = $data['first_name'];
			$user_check->last_name = $data['last_name'];
			$user_check->address = $data['address'];
			$user_check->latitude = $data['latitude'];
			$user_check->longitude = $data['longitude'];
		    $file = $user_check->avatar;
		    if(File::exists($file)){
		    	File::delete($file);
		    }        	
		    $user_check->avatar = 'assets/media/'.$this->updateImageProfile($data['image']);
		    $user_check->save();
		   
		    $data_user = User::select('users.email','users.first_name','users.last_name','users.phone','users.address','users.latitude','users.longitude','users.avatar','users.active','role_users.role_id')
			            ->join('role_users', 'users.id', '=', 'role_users.user_id')
			            ->join('roles', 'roles.id', '=', 'role_users.role_id')
		    			->where('users.id',$user_check->id)
		    			//->where('role_users.user_id',$user_check->id)
		    			->first();
		    return $data_user;

		}
	}
	public function getNews($country){
		//return $country;
		$news = News::select('news.*')->where('country',$country)
				// ->with('user')
				->join('users', 'users.id', '=', 'news.user_id');
				$news->orderBy('id','DESC')->get();
		return $news;

	}
}
