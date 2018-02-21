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
use Modules\Motel\Entities\Room;
use Modules\Motel\Entities\Imgs;
use Modules\Motel\Entities\MappingNewsUser;

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
            $tail  = $file->getClientOriginalExtension();
            $filepath = public_path('assets/media');
            // $img = \Image::make($file);
            // $img->resize(50,50);
            \Image::make($file->getRealPath())->resize(200, 200)->save("$filepath/$filename");
            // if($file->move($filepath, $filename))
            // {
            //     $filepathLocal = $filepath . "/" . $filename;

            //    //$url = S3::uploadFile($filepathLocal,$filename);
            // }
        }
        // if($filepathLocal){
        //     @unlink($filepathLocal);
        // }

       return $filename;
    }
 	public function updateImageMotel($file)
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
            \Image::make($file->getRealPath())->resize(200, 200)->save("$filepath/thumb_$filename");
            if($file->move($filepath, $filename))
            {
                $filepathLocal = $filepath . "/" . $filename;

               //$url = S3::uploadFile($filepathLocal,$filename);
            }
        }
        // if($filepathLocal){
        //     @unlink($filepathLocal);
        // }
        $arr = [];
       return $arr = [
       	'img' => $filename,
       	'thumb_img' =>"thumb_".$filename
       ];
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
			$user_find->getRoleUser()->attach(3);

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
	public function getRoomOfUser(){
		$user = Auth::guard('api')->user();
		$room = Room::where('user_id',$user->id)->orderBy('id','DESC');
		return $room;
	}
	public function getNews($country){
		//return $country;
		$news = News::selectRaw('news.*, users.email as created_by,users.first_name,users.last_name,users.avatar')
		->with(array('image'=>function($query){
        	 //$query->select('sub_image','sub_image_thumb');
   		}))
		->where('country',$country)->where('status',1)
				//->with('user')
				->join('users', 'users.id', '=', 'news.user_id');
				//->join('image', 'image.new_id', '=', 'news.id');
				$news->orderBy('id','DESC');
		return $news;

	}
	public function getNewsOfCurrenUser(){
		$user = Auth::guard('api')->user();
		$news = News::selectRaw('news.*, users.email as created_by,users.first_name,users.last_name,users.avatar')
		->with(array('image'=>function($query){
        	 //$query->select('sub_image','sub_image_thumb');
   		}))
		->where('status',1)
		->where('user_id',$user->id)
				//->with('user')
				->join('users', 'users.id', '=', 'news.user_id');
				//->join('image', 'image.new_id', '=', 'news.id');
				$news->orderBy('id','DESC');
		return $news;

	}
	public function deleteNewsOfUser($id){
		$user = Auth::guard('api')->user();
		$news = News::where('id',$id)->where('user_id',$user->id)->first();
		if($news){
			$images = Imgs::where('new_id',$news->id)->get();
			if(count($images)>0){
				foreach($images as $value){
			      if(File::exists($value->sub_image)){
			          File::delete($value->sub_image);
			      }
			      if(File::exists($value->sub_image_thumb)){
			          File::delete($value->sub_image_thumb);
			      }
			      $value->delete();
				}
				
			}
			$news->delete();
			return true;
		}

	}
	public function likeNews($id){
		$user = Auth::guard('api')->user();
		$data = new MappingNewsUser();
		$data->user_id = $user->id;
		$data->news_id = $id;
		$data->save();
		return true;

	}
	public function getNewsLikedOfUser(){
		$user = Auth::guard('api')->user();
		$news = News::selectRaw('news.*, users.email as created_by,users.first_name,users.last_name,users.avatar')
		->with(array('image'=>function($query){
        	 //$query->select('sub_image','sub_image_thumb');
   		}))
		->where('status',1)
		//->where('mapping_news_users.user_id',$user->id)
				//->with('user')
		->join('users', 'users.id', '=', 'news.user_id')
		->join('mapping_news_users', 'mapping_news_users.news_id', '=', 'news.id')
		//->join('users', 'mapping_news_users.user_id', '=', 'users.id')
		->where('news.user_id',$user->id);
		$news->orderBy('id','DESC');
		return $news;		
	}
	public function unlikeNewsByUser($id){
		$user = Auth::guard('api')->user();
		$data = MappingNewsUser::where('user_id',$user->id)->where('news_id',$id)->first();
		if($data){
			$data->delete();
			return true;
		}
		
	}
	public function getListFilter($latitude, $longitude, $limit, $unit_price = 0){
		if($unit_price == 1 ){
			$query = " SELECT *, (2 * (6371 * ATAN2(SQRT(POWER(SIN((RADIANS(".$latitude." - latitude ) ) / 2 ), 2 ) + COS(RADIANS(latitude)) *COS(RADIANS(".$latitude.")) * POWER(SIN((RADIANS(".$longitude." - longitude ) ) / 2 ), 2 )),SQRT(1-(POWER(SIN((RADIANS(".$latitude." - latitude ) ) / 2 ), 2 ) + COS(RADIANS(latitude)) * COS(RADIANS(".$latitude.")) * POWER(SIN((RADIANS(".$longitude." - longitude ) ) / 2 ), 2 )))))) AS 'distance' from news where status = 1 and unit_price <= 5000000 HAVING distance <". $limit;	
		}elseif($unit_price == 2){
			$query = " SELECT *, (2 * (6371 * ATAN2(SQRT(POWER(SIN((RADIANS(".$latitude." - latitude ) ) / 2 ), 2 ) + COS(RADIANS(latitude)) *COS(RADIANS(".$latitude.")) * POWER(SIN((RADIANS(".$longitude." - longitude ) ) / 2 ), 2 )),SQRT(1-(POWER(SIN((RADIANS(".$latitude." - latitude ) ) / 2 ), 2 ) + COS(RADIANS(latitude)) * COS(RADIANS(".$latitude.")) * POWER(SIN((RADIANS(".$longitude." - longitude ) ) / 2 ), 2 )))))) AS 'distance' from news where status = 1 and unit_price > 5000000 HAVING distance <". $limit;	
		}else{
			$query = " SELECT *, (2 * (6371 * ATAN2(SQRT(POWER(SIN((RADIANS(".$latitude." - latitude ) ) / 2 ), 2 ) + COS(RADIANS(latitude)) *COS(RADIANS(".$latitude.")) * POWER(SIN((RADIANS(".$longitude." - longitude ) ) / 2 ), 2 )),SQRT(1-(POWER(SIN((RADIANS(".$latitude." - latitude ) ) / 2 ), 2 ) + COS(RADIANS(latitude)) * COS(RADIANS(".$latitude.")) * POWER(SIN((RADIANS(".$longitude." - longitude ) ) / 2 ), 2 )))))) AS 'distance' from news where status = 1 HAVING distance <". $limit;
		}
		$data = DB::select($query);
		$arr = [];
		foreach($data as $k => $v){
			$img = Imgs::select('sub_image','sub_image_thumb')->where('new_id',$v->id)->get();
			$user = User::select('first_name','last_name','avatar')->where('id',$v->user_id)->first();
			$arr[$k] = $v;
			$arr[$k]->image = $img;
			if($user){
				$arr[$k]->first_name = $user->first_name;
				$arr[$k]->last_name = $user->last_name;
				$arr[$k]->avatar = $user->avatar;
			}
		}
		return $arr;
	}
	public function postNews($data){

		$user = Auth::guard('api')->user();
		//return $user;
		$new = new News();
   		$new->location = $data['location'];
        $new->erea = $data['erea'];
        $new->unit_price = $data['unit_price'];
        $new->phone = $data['phone'];
        $new->description = $data['description'];
        $new->country = $data['country'];
        $new->user_id = $user->id;
        $new->latitude = $data['latitude'];
        $new->longitude = $data['longitude'];
        $new->status = 1;
        $new->save();


        if($data['sub1']){
        	$result_img = $this->updateImageMotel($data['sub1']);
	        $img = new Imgs();
	        $img->new_id = $new->id;
	        $img->sub_image = 'assets/media/'.$result_img['img'];
	        $img->sub_image_thumb = 'assets/media/'.$result_img['thumb_img'];
	        $img->save();
        }
        if($data['sub2']){
			$result_img = $this->updateImageMotel($data['sub2']);
	        $img = new Imgs();
	        $img->new_id = $new->id;
	        $img->sub_image = 'assets/media/'.$result_img['img'];
	        $img->sub_image_thumb = 'assets/media/'.$result_img['thumb_img'];
	        $img->save();
    	}
    	if($data['sub3']){
			$result_img = $this->updateImageMotel($data['sub3']);
	        $img = new Imgs();
	        $img->new_id = $new->id;
	        $img->sub_image = 'assets/media/'.$result_img['img'];
	        $img->sub_image_thumb = 'assets/media/'.$result_img['thumb_img'];
	        $img->save();
    	}
    	if($data['sub4']){
			$result_img = $this->updateImageMotel($data['sub4']);
	        $img = new Imgs();
	        $img->new_id = $new->id;
	        $img->sub_image = 'assets/media/'.$result_img['img'];
	        $img->sub_image_thumb = 'assets/media/'.$result_img['thumb_img'];
	        $img->save();
    	}

       	return true;
        //$new->sub1 = 'assets/media/'.$this->updateImageProfile($data['image']);

	}
}
