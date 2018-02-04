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
use Yajra\Datatables\Datatables;
use Modules\Motel\Http\Requests\CreateRoomRequest;
use Auth;
use Modules\User\Contracts\Authentication;

class RoomController extends AdminBaseController
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
		//$vehicle = Vehicle::where('type_id',Vehicle::VEHICLE_TYPE_ID)->get();

        return view('motel::admin.room.index');
	}
	public function indextable(){
			$currentUser = $this->auth->user()->id;
			$items = Room::where('user_id',$currentUser)->get();
			//dd($items);
	        $collection = collect($items);
 			return $this->datatables->of($collection)
			        ->editColumn('erea', function( $room) {
			        			return $room->getArea();
			                })
			        ->editColumn('giaphong', function( $room) {
			        			return $room->getGiaPhong();
			                })
			        ->editColumn('tiendien', function( $room) {
			        			return $room->getTienDien();
			                })
			        ->editColumn('tiennuoc', function( $room) {
			        			return $room->getTienNuoc();
			                })
                	->addColumn('select', function(Room $room) {
                    		if($room->status==1){
                    			return '<div id="check'.$room->id.'" class="check-stt" data-value="'.$room->id.'" status="1">
                			<span class="label label-success" style="cursor: pointer; padding:7px" >Còn trống</span></div>';
                    		}else{
                    			return '<div id="check'.$room->id.'" class="check-stt" data-value="'.$room->id.'" status="0">
                			<span class="label label-danger" style="cursor: pointer; padding:7px" >Đang thuê</span></div>';
                    		}
                		})
                    ->addColumn('check', '<input class = "check" type="checkbox" name="selected_room[]" value="{{ $id }}">')
                    ->addColumn('button', '<div class ="button_action">
		                    	<a title=Edit Room" class="btn btn-default btn-flat" href="{{ route("admin.room.room.edit",$id) }}" style="margin-right:3px"><i class="fa fa-pencil"></i></a> 
		                    	<button title="Delete Room" class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{route("admin.room.room.delete",$id)}}"><i class="fa fa-trash"></i></button> </div>
		                    	')
                    ->rawColumns(['check', 'action','button','select'])->make(true);
    }
    public function create(){
    	return view('motel::admin.room.create');
    }
    public function store(CreateRoomRequest $request){
    	$currentUser = $this->auth->user()->id;
    	$data = $request->all();
    	$data['user_id'] = $currentUser;
    	unset($data['_token']);
    	Room::create($data);
    	//dd(1);
    	return redirect()->route('admin.room.room.index')
            ->withSuccess(trans('Tạo mới thành công'));
    }
	public function edit($id){
		//return 1;
		$room = Room::find($id);
		if(!$room){
			abort(404);
		}else{
			return view('motel::admin.room.edit',compact('room'));
		}
	}
	public function update(CreateRoomRequest $request, $id){
		$room = Room::find($id);
		$room->name = $request->name;
		$room->erea = $request->erea;
		$room->unit_price = $request->unit_price;
		$room->payment_on_electricity = $request->payment_on_electricity;
		$room->payment_of_water = $request->payment_of_water;
		$room->save();
		return redirect()->back()
        ->withSuccess(trans('Chỉnh sửa thành công'));		
	}
	public function delete(Request $request, $id){
		$room = Room::find($id);
		if($room){
			$room_check = $room->checkPhongThue();
			if($room_check == false){
				return redirect()->back()
        			->withWarning(trans('Bạn phải xóa tất cả thủ tục đặt phòng này trước khi thực hiện thao tác xóa phòng'));
			}
			$room->delete();
		}

        return redirect()->route('admin.room.room.index')
            ->withSuccess(trans('Xoá thành công'));
	}
	public function changeStatus(Request $request){
		$room_id = $request->get('room_id');
		$status = $request->get('status');
		if($status == 1){
			$status = 0;
			$room = Room::find($room_id);
			$room->status = $status;
			$room->save();
		}else{
			$status = 1;
			$room = Room::find($room_id);
			$room->status = $status;
			$room->save();
		}
		return $status;
	}
	public function bulkDelete(Request $request){
		$id = [];
        $id = $request->id;
        if($id == null){
            $request->session()->flash('danger','Chọn các mục trước khi xoá');
            return 2;
        }else{

            $room = Room::find($id);
            if($room->checkPhongThue() == false){
        		return 2;
        	}
        	$room->delete();
            $request->session()->flash('success','Xoá thành công');
            return 1;
        } 
	}
}