<?php

namespace Modules\Motel\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Motel\Entities\Motel;
use Modules\Motel\Http\Requests\CreateMotelRequest;
use Modules\Motel\Http\Requests\UpdateMotelRequest;
use Modules\Motel\Repositories\MotelRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Motel\Entities\Room;
use Modules\Motel\Entities\Bookings;
use Modules\Motel\Entities\Config;
use Yajra\Datatables\Datatables;
use Modules\Motel\Http\Requests\CreateRoomRequest;
use Auth;
use Modules\User\Contracts\Authentication;

class ConfigController extends AdminBaseController
{
    /**
     * @var MotelRepository
     */
    private $motel;
    private $datatables;
    private $auth;

    public function __construct(MotelRepository $motel,Datatables $datatables, Authentication $auth)
    {
        parent::__construct();

        $this->motel = $motel;
        $this->datatables = $datatables;
        $this->auth = $auth;
    }
    public function index(){
		$currentUser = $this->auth->user()->id;
        $item = Config::where('user_id',$currentUser)->first();
        if($item){
            return view('motel::admin.config.index',compact('item')); 
        }else{
            $item = new Config();
            $item->payment_on_electricity = 3000;
            $item->payment_of_water = 15000;
            $item->trash = 20000;
            $item->internet = 100000;
            $item->parking = 50000;
            $item->user_id = $currentUser;
            $item->save();
            return view('motel::admin.config.index',compact('item'));  
        }

	}
	public function indextable(){
			$currentUser = $this->auth->user()->id;
			$items = Config::where('user_id',$currentUser)->first();
			$arr = ['Điện','Nước','Giữ xe','Tiền đổ rác','Tiền Internet'];
            $dataNew = collect($arr);
            dd($items);
	        $collection = collect($items);
 			return $this->datatables->of($collection)
                    ->editColumn('phi', function( $room) {
                                return $dataNew->items;
                            })
                    ->addColumn('check', '<input class = "check" type="checkbox" name="selected_room[]" value="{{ $id }}">')
                    ->addColumn('button', '<div class ="button_action">
		                    	<a title=Edit Room" class="btn btn-default btn-flat" href="{{ route("admin.room.room.edit",$id) }}" style="margin-right:3px"><i class="fa fa-pencil"></i></a> 
		                    	<button title="Delete Room" class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{route("admin.room.room.delete",$id)}}"><i class="fa fa-trash"></i></button> </div>
		                    	')
                    ->rawColumns(['check', 'action','button','select'])->make(true);
    }
    public function postConfig(Request $request){
        $currentUser = $this->auth->user()->id;
        $data_check = Config::where('user_id',$currentUser)->first();
        if($data_check){
            $data_check->payment_on_electricity = $request->payment_on_electricity;
            $data_check->payment_of_water = $request->payment_of_water;
            $data_check->trash = $request->trash;
            $data_check->internet = $request->internet;
            $data_check->parking = $request->parking;
            $data_check->save();
        }else{
            $data_new = new Config();
            $data_new->payment_on_electricity = $request->payment_on_electricity;
            $data_new->payment_of_water = $request->payment_of_water;
            $data_new->trash = $request->trash;
            $data_new->internet = $request->internet;
            $data_new->parking = $request->parking;
            $data_new->save();            
        }
        return redirect()->back()
        ->withSuccess('Cập nhật thành công');
    }
}