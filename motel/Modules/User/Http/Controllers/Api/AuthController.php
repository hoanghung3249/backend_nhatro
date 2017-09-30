<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Services\UserRegistration;
use Modules\User\Services\UserResetter;
use Modules\User\Entities\Sentinel\User;
use Modules\User\Entities\Sentinel\UserAPI;
use Auth;
use Hash;
use Illuminate\Http\Response;
use Mail;
use Modules\User\Entities\RoleUser;
use Modules\User\Entities\Countries;
use Carbon\Carbon;
use Modules\User\Http\Requests\APISigninRequest;
use Modules\Portfolios\Entities\ResetPassword;
//use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\Sentinel\SentinelUserRepository;
use Modules\User\Entities\Sys\UserSetting;
use Nexmo\Laravel\Facade\Nexmo;

class AuthController extends ApiController
{
    /**
     * @var UserRepository
     */
    public $user;

    public function __construct( SentinelUserRepository $user)
    {
        $this->user = $user;
    }
    /**
     * @SWG\Get(
     *   path="/members/getLogout",
     *   description="",
     *   summary="",
     *   operationId="api.members.getLogout",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Response(response=401, description="unauthorized"),
     *   @SWG\Response(response=200, description="Success"),
     *   security={
     *       {"api_key": {}}
     *   }
     * )
     */
    public function getLogout(Request $request)
    {
        $user = Auth::guard('api')->user();
        //return $user;
        
        $user->token()->revoke();
        return $this->respond([
            'status' => 'success',
            'status_code' => 200,
            'message' => "Logout successful!",
        ]);
    }

    /**
     * @SWG\Post(
     *   path="/members/postLogin",
     *   description="<ul>
     *     <li>email : string (required)</li>
     *     <li>password : string (required)</li></ul>",
     *   summary="Login",
     *   operationId="api.members.postLogin",
     *   produces={"application/json"},
     *   tags={"Authenticate"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Target customer.",
     *     required=true,
     *    @SWG\Schema(ref="#/definitions/Customer")
     *   ),
     *   @SWG\Response(response=101, description="Wrong email or password"),
     *   @SWG\Response(response=102, description="You need to confirm your account"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     */
    public function postLogin(Request $request)
    {
        $customer = User::where('email',$request->email)->first();

        if(isset($customer) && !empty($customer))
        {
            if (Hash::check($request->password, $customer->password) && $customer->status !=3)
            {

                    $token = $customer->createToken('Login Token')->accessToken;
                    $item = $customer->withAccessToken($token);
                    $data = [
                        'first_name' =>$customer->first_name,
                        'last_name' =>$customer->last_name,
                        'phone' =>$customer->phone,
                        'email'=>$customer->email,
                        'address'=>$customer->address,
                        'active' =>$customer->active,
                        'total_motel'=>$customer->total_motel,
                        'avatar'=>$customer->avatar,
                        //'gender'=>$customer->gender,
                        'token'=>$token

                    ];
                    return $this->respondWithSuccess($data,'Login successful!');

            }
                
        }
        return $this->respondInternalError('Wrong email or password');
    }
    /**
     * @SWG\Post(
     *     path="/members/postSignup",
     *     description="<ul>
     *     <li>email : string (required)</li>
     *     <li>first name : string (required)</li>
     *     <li>last name : string (required)</li>
     *     <li>password : string (required)</li>
          <li>phone number : string (required)</li></ul>",
     *     tags={"Authenticate"},
     *     operationId="addPet",
     *     summary="Register user",
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(ref="#/definitions/Register")
     *     ),
     *     @SWG\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     *  
     * )
     */
    public function postSignup(Request $request){
        $check = User::where('email',$request->email)->first();

        if(!$check){
            $user = new User();
            $user->email = $request->email;
            $user->first_name =$request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->total_motel = 0;
            $user->password = Hash::make($request->password);
            //$user->gender = $request->gender;
            $user->active = 0;
            $user->remember_token = str_random(40);

            $user->save();
            $role_user = new RoleUser();
            $role_user->user_id = $user->id;
            $role_user->role_id = 2;
            $role_user->save();

            Mail::send('user::sentemail.register', ['user'=>$user], function ($message) use($user)
            {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($user->email,$user->fist_name);
                //$message->bcc(env('MAIL_BCC'));
                $message->subject('Welcome to Services Solution');
            });
                    $token = $user->createToken('Login Token')->accessToken;
                    $item = $user->withAccessToken($token);
                    $data = [
                        'first_name' =>$user->first_name,
                        'last_name' => $user->last_name,
                        'phone' =>$user->phone,
                        'email'=>$user->email,
                        'address'=>$user->address,
                        'active' =>$user->active,
                        'total_motel'=>$user->total_motel,
                        'avatar'=>$user->avatar,
                        //'gender'=>$user->gender,
                        'token'=>$token

                    ];
                    return $this->respondWithSuccess($data,'We have sent a link to the your email address, please go to the mail box to confirm');
        }
        return $this->respondInternalError('Email already exists');        
    }
    /**
     * @SWG\Post(
     *     path="/members/change-password",
     *     description="<ul>
     *     <li>password : string (required)</li></ul>",
     *     tags={"Authenticate"},
     *     operationId="addPet",
     *     summary="Register user",
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=false,
     *         @SWG\Schema(ref="#/definitions/Changepassword")
     *     ),
     *     @SWG\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *   security={
     *       {"api_key": {}}
     *   }
     *  
     * )
     */
    public function postChangepassword(Request $request){
        $user = Auth::guard('api')->user();
        $check = User::where('id',$user->id)->first();
        if($check){
            $user = User::find($user->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "Change password successful!",
            ]);
        }else{
           return $this->respondNotFound("Id user not found");      
        }
    }
    /**
     * @SWG\Post(
     *     path="/members/forgot-password",
     *     description="<ul>
           <li>email : string (required)</li></ul>",
     *     tags={"Authenticate"},
     *     operationId="",
     *     summary="Forgot password",
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Forgotpassword")
     *     ),
     *     @SWG\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={{"petstore_auth":{"write:pets", "read:pets"}}}
     * )
     */
    public function postForgotpassword(Request $request){
        $token = str_random(40);
        //return $token;
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return $this->respondNotFound("Email does not exist"); 
        }else{
            $user->remember_token = $token;
            $datetime = Carbon::now();
            $user->exist_time = $datetime;
            $user->save();
            Mail::send('user::sentemail.forgotpassword', ['user'=>$user , 'token' => $token], function ($message) use($user)
            {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($user->email,$user->fist_name);
                //$message->bcc(env('MAIL_BCC'));
                $message->subject('Change password');
            });
            return $this->respond([
                'status' => 'success',
                'status_code' => 200,
                'message' => "We have sent a link to the your email address, please go to the mail box to confirm",
            ]);
        }
    }

}
