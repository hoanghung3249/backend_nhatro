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
use Modules\Motel\Entities\Customer;
use Yajra\Datatables\Datatables;
use Modules\Motel\Http\Requests\CreateRoomRequest;
use Auth;
use Modules\User\Contracts\Authentication;
use Carbon\Carbon;

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
		                    	<a title=Edit Room" class="btn btn-default btn-flat" href="{{ route("admin.bookings.bookings.edit",$id) }}" style="margin-right:3px"><i class="fa fa-pencil"></i></a> 
		                    	<button title="Delete Room" class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{route("admin.bookings.bookings.destroy",$id)}}"><i class="fa fa-trash"></i></button> </div>
		                    	')
                    ->rawColumns(['check', 'action','button','select'])->make(true);
    }
    public function create(){
        $currentUser = $this->auth->user()->id;
        // $customer = Customer::where('user_id',$currentUser)->get();
        // dd($customer);
        $room = Room::where('status',1)->where('user_id',$currentUser)->get();
        return view('motel::admin.bookings.create',compact('room'));
    }
    // public function getIDCusBySession(Request $request){
    //     $a = session()->put('id_cus',$request->id_cus);
    //     //dd($a);

    // }
    public function getCustomer(Request $request){
        $currentUser = $this->auth->user()->id;
        $term = $request->term;
        $data = Customer::where('full_name','LIKE','%'.$term.'%')->where('user_id',$currentUser);
        // ->where('booking_id',null)
        $data = $data->take(10)->get();
        $result = array();
        foreach ($data as $key => $v){
            $result[] = ['id'=>$v->id,'value'=>$v->full_name,'dob'=>$v->getDOB(),'gender'=>$v->getGioiTinh(),'phone'=>$v->phone];
        }
        return response()->json($result);
    }
    public function getCustomerForCreate(Request $request){
        $term = $request->term;
        $currentUser = $this->auth->user()->id;
        $data = Customer::where('full_name','LIKE','%'.$term.'%')->where('booking_id',null)->where('user_id',$currentUser);
        $data = $data->take(10)->get();
        $result = array();
        foreach ($data as $key => $v){
            $result[] = ['id'=>$v->id,'value'=>$v->full_name,'dob'=>$v->getDOB(),'gender'=>$v->getGioiTinh(),'phone'=>$v->phone];
        }
        return response()->json($result);        
    }
    public function store(Request $request){
        //dd($request->id_cus);

        $currentUser = $this->auth->user()->id;
        $date = Carbon::parse($request->start_date)->format('Y-m-d');
        $data = new Bookings();
        $data->user_id = $currentUser;
        $data->start_date = $date;
        $data->unit_price = $request->unit_price;
        $data->down_payment = $request->down_payment;
        $data->room_id = $request->room_id;
        $data->number_of_bike = $request->number_of_bike;
        $data->note = $request->note;
        $data->save();
        if($request->id_cus != null){
            foreach($request->id_cus as $item){
                $data->customer_id = $item;
                $data->save();
                break;
            }
            foreach($request->id_cus as $item){
                $customer = Customer::where('id',$item)->first();
                if($customer){
                    $customer->booking_id = $data->id;
                    $customer->save();
                }
            }
        }
        
        $room = Room::find($request->room_id);
        if($room){
            $room->status = 0;
            $room->save();
        }
        return redirect()->route('admin.bookings.bookings.index')
            ->withSuccess(trans('Tạo mới thành công')); 
    }
    public function edit($id){
        $currentUser = $this->auth->user()->id;
        $booking = Bookings::find($id);
        $room = Room::where('user_id',$currentUser)->get();
        $customer_of_room = Customer::where('booking_id',$booking->id)->get();
        if(!$booking){
            abort(404);
        }else{
            return view('motel::admin.bookings.edit',compact('booking','room','customer_of_room'));
        }        
    }
    public function update(Request $request, $id){
        $data = Bookings::find($id);
        $data->unit_price = $request->unit_price;
        $data->down_payment = $request->down_payment;
        $data->number_of_bike = $request->number_of_bike;
        $data->note = $request->note;
        $data->save();
        $customer = Customer::where('booking_id',$data->id)->get();
        if(count($customer)>0){
            foreach($customer as $item){
                $item->booking_id = null;
                $item->save();
            }
        }
        //dd($customer);
        if($request->id_cus != null){
            foreach($request->id_cus as $item){
                $data->customer_id = $item;
                $data->save();
                break;
            }
            foreach($request->id_cus as $item){
                $customer = Customer::where('id',$item)->first();
                if($customer){
                    $customer->booking_id = $data->id;
                    $customer->save();
                }
            }
        }
        return redirect()->back()
            ->withSuccess(trans('Chỉnh sửa thành công'));        
    }
    public function destroy(Request $request, $id){
        $booking = Bookings::find($id);
        if($booking){
            $room = Room::find($booking->room_id);
            if($room){
                $room->status = 1;
                $room->save();
            }
            $customer_of_booking = Customer::where('booking_id',$booking->id)->get();
            if(count($customer_of_booking)>0){
                foreach($customer_of_booking as $item){
                    $item->booking_id = null;
                    $item->save();
                }
            }
            $booking->delete();
        }

        return redirect()->route('admin.bookings.bookings.index')
            ->withSuccess(trans('Xoá thành công'));        
    }
}