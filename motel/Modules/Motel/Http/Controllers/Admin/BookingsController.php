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
use Yajra\Datatables\Datatables;
use Modules\Motel\Http\Requests\CreateRoomRequest;
use Auth;
use Modules\User\Contracts\Authentication;

class BookingsController extends AdminBaseController
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

        return view('motel::admin.bookings.index');
	}
	public function indextable(){
			$currentUser = $this->auth->user()->id;
			$items = Bookings::where('user_id',$currentUser)->get();
			// //dd($items);
   //          dd($items);
	        $collection = collect($items);
 			return $this->datatables->of($collection)
                    ->editColumn('tenphong', function( $room) {
                                return $room->getTenPhong();
                            })
                    // ->editColumn('customer', function( $room) {
                    //             return $room->getTenKhachHang();
                    //         })
			        ->editColumn('giaphong', function( $room) {
			        			return $room->getGiaPhong();
			                })
			        ->editColumn('tiendien', function( $room) {
			        			return $room->getTienDien();
			                })
			        ->editColumn('tiennuoc', function( $room) {
			        			return $room->getTienNuoc();
			                })
                    ->editColumn('tiencoc', function( $room) {
                                return $room->getTienCoc();
                            })
                    ->editColumn('ngaythue', function( $room) {
                                return $room->getNgaythue();
                            })
                    ->editColumn('ngaytra', function( $room) {
                                return $room->getNgaytra();
                            })
                	// ->addColumn('select', function(Room $room) {
                 //    		if($room->status==1){
                 //    			return '<div id="check'.$room->id.'" class="check-stt" data-value="'.$room->id.'" status="1">
                	// 		<span class="label label-success" style="cursor: pointer; padding:7px" >Còn trống</span></div>';
                 //    		}else{
                 //    			return '<div id="check'.$room->id.'" class="check-stt" data-value="'.$room->id.'" status="0">
                	// 		<span class="label label-danger" style="cursor: pointer; padding:7px" >Đang thuê</span></div>';
                 //    		}
                	// 	})
                    ->addColumn('check', '<input class = "check" type="checkbox" name="selected_room[]" value="{{ $id }}">')
                    ->addColumn('button', '<div class ="button_action">
		                    	<a title=Edit Room" class="btn btn-default btn-flat" href="{{ route("admin.room.room.edit",$id) }}" style="margin-right:3px"><i class="fa fa-pencil"></i></a> 
		                    	<button title="Delete Room" class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{route("admin.room.room.delete",$id)}}"><i class="fa fa-trash"></i></button> </div>
		                    	')
                    ->rawColumns(['check', 'action','button','select'])->make(true);
    }
    public function create(){
        return view('motel::admin.bookings.create');
    }
}