<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 7/3/17
 * Time: 16:25
 */

namespace Modules\User\Http\Controllers\Frontend;


use Modules\User\Http\Requests\UpdatepasswordRequest;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Sentinel\User;
use Illuminate\Http\Request;

class ResetpasswordController extends Controller
{
    public function getResetpassword(Request $request){
        $check = User::where([
                        ['id',$request->id],
                        ['remember_token',$request->token]
                    ])->first();
        if(!$check){
            abort(404);
        }else{
            $id = $request->id;
            $token = $request->token;
            return view('user::resetpassword',compact('id','token'));
        }
        
    }
    public function postResetpassword(UpdatepasswordRequest $request){

        $token_new = str_random(40);
        $id = $request->id;
        $token = $request->token;
        $check = User::where([
                        ['id',$id],
                        ['remember_token',$token]
                    ])->first();
        if($check){
            $user = User::find($id);
            $user->password = bcrypt($request->password);
            $user->remember_token = $token_new;
            $user->save();
            return redirect()->route('resetpasswordsuccess')->with(['message'=>'Update password successful!']);
        }else{
            abort(404);
        }
    }
    public function getShowmessage(){
        return view('user::success');
    }
}