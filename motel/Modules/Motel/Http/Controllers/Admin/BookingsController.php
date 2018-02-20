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
use Modules\Motel\Entities\Bills;
use Modules\Motel\Entities\BillsDetail;
use Modules\Motel\Entities\Config;

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
                                <a title="Calculator" class="btn btn-default btn-flat" href="{{ route("admin.bills.bills.indexbills",$id) }}" style="margin-right:3px"><i class="fa fa-calculator"></i></a> 
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
        $data = Customer::with('getPhongTro')->where('full_name','LIKE','%'.$term.'%')->where('user_id',$currentUser);
        // ->where('booking_id',null)
        $data = $data->take(10)->get();
        //return response()->json($data);
        $result = array();
        foreach ($data as $key => $v){
            $result[] = ['id'=>$v->id,'value'=>$v->full_name,'dob'=>$v->getDOB(),'gender'=>$v->getGioiTinh(),'phone'=>$v->phone,'booking_id'=>$v->booking_id];
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
            $result[] = ['id'=>$v->id,'value'=>$v->full_name,'dob'=>$v->getDOB(),'gender'=>$v->getGioiTinh(),'phone'=>$v->phone,'booking_id'=>$v->booking_id];
        }
        return response()->json($result);        
    }
    // public function getAllCustomerAjax(Request $request){
    //     $currentUser = $this->auth->user()->id;
    //     $arr_id_edit = [];
    //     $arr_id_edit = $request->get('arr');
    //     //return $arr_id_edit;
    //     $data = Customer::where('booking_id','<>',null)->whereNotIn('id',$arr_id_edit)->where('user_id',$currentUser)->get();
    //     $data_new = collect($data)->map(function($item) {
    //         return $item->id;
    //     })->toArray();
    //     return $data_new;
        
    // }
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




    public function indexbills($id){
        session()->put('id',$id);
        return view('motel::admin.bookings.bill');
    }
    public function indextablebills(){
        $booking_id = session()->get("id");
        $currentUser = $this->auth->user()->id;
            $items = Bills::where('user_id',$currentUser)->where('booking_id',$booking_id)->get();
            $collection = collect($items);
            //session()->forget('id');
            return $this->datatables->of($collection)
                    ->editColumn('thang', function( $room) {
                                return $room->getThang();
                            })
                    ->editColumn('total', function( $room) {
                                return $room->getTotal();
                            })
                    ->editColumn('datra', function( $room) {
                                return $room->getDaTra();
                            })
                    ->editColumn('conlai', function( $room) {
                                return $room->getConLai();
                            })
                    ->editColumn('no', function( $room) {
                                return $room->getNo();
                            })
                    ->editColumn('ngaytra', function( $room) {
                                return $room->getNgayTra();
                            })
                    ->addColumn('check', '<input class = "check" type="checkbox" name="selected_room[]" value="{{ $id }}">')
                    ->addColumn('button', '<div class ="button_action">
                                <a title=Edit Room" class="btn btn-default btn-flat" href="{{ route("admin.bills.bills.indexbillsdetail",$id) }}" style="margin-right:3px"><i class="fa fa-pencil"></i></a>
                                <button title="Delete Room" class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{route("admin.bookings.bookings.destroy",$id)}}"><i class="fa fa-trash"></i></button> </div>
                                ')
                    ->rawColumns(['check', 'action','button','select'])->make(true);        
    }
    public function indexbillsdetail($id){ 
        $currentUser = $this->auth->user()->id;
        $last_month = Carbon::now()->subMonth()->format('Y-m');
        $now_month = Carbon::now()->format('Y-m');
        //dd($last_month);
        $check_index = BillsDetail::where('user_id',$currentUser)
                                       ->where('bills_id',$id)
                                       ->whereRaw("DATE_FORMAT(created_at,'%Y-%m')='{$last_month}'")
                                       ->first();
                                       //dd($electric_index);
        if($check_index){
            $electricity_index = $check_index->electricity_index;
            $water_index = $check_index->water_index;
            $owe = $check_index->owe;

        }else{
            $electricity_index = 0;
            $water_index = 0 ;
            $owe = 0;
        }
        //dd((int)$electric_index);

        $config = Config::where('user_id',$currentUser)->first();
        $bills = Bills::with('getBooking')->where('user_id',$currentUser)->where('id',$id)->first();
        $bills_detail_month_now = BillsDetail::where('user_id',$currentUser)
                                                ->where('bills_id',$bills->id)
                                                ->whereRaw("DATE_FORMAT(created_at,'%Y-%m')='{$now_month}'")
                                                ->first();
        
        $price_room = number_format($bills->getBooking->getRoom->unit_price,0,'.','.');

        $room_price = $bills->getBooking->getRoom->unit_price;
        $total = $bills_detail_month_now->payment_on_electricity + $bills_detail_month_now->payment_of_water + $bills_detail_month_now->parking + $bills_detail_month_now->trash + $bills_detail_month_now->internet + $room_price;
        return view('motel::admin.bookings.bill_detail',compact('config','price_room','bills','electricity_index','water_index', 'total','room_price','owe','bills_detail_month_now'));

    }
    public function postBillsDetail(Request $request){
        $currentUser = $this->auth->user()->id;
        $now_month = Carbon::now()->format('Y-m');
        $bills_detail_month_now = BillsDetail::where('user_id',$currentUser)
                                                ->where('bills_id',$request->bill_id)
                                                ->whereRaw("DATE_FORMAT(created_at,'%Y-%m')='{$now_month}'")
                                                ->first();
        $bill = Bills::where('user_id',$currentUser)
                        ->where('id',$request->bill_id)
                        ->whereRaw("DATE_FORMAT(created_at,'%Y-%m')='{$now_month}'")
                        ->first();                                       
        if($bills_detail_month_now && $bill){
            $thanhtiendien = ($request->electricity_index_new - $request->electricity_index) * $request->tiendiencontroller;
            $thanhtiennuoc = ($request->water_index_new - $request->water_index) * $request->tiennuoccontroller;
            $thanhtiengiuxe = $request->soxe * $request->tienxecontroller;
            $tongcong = $thanhtiendien + $thanhtiennuoc + $thanhtiengiuxe + $request->tienracinput + $request->tieninternetinput + $request->tienphonginput;
            $conlai = $request->datrainput - ($tongcong + $request->noinput);
            $date_paid = Carbon::parse($request->date_paid)->format('Y-m-d');
            // dd($request->all());
            $bill->total = $tongcong;
            $bill->paid = $request->datrainput;
            $bill->date_paid = $date_paid;
            $bill->created_at = Carbon::now();
            $bill->save();

            $bills_detail_month_now->payment_on_electricity = $thanhtiendien;
            $bills_detail_month_now->payment_of_water = $thanhtiennuoc;
            $bills_detail_month_now->parking = $thanhtiengiuxe;
            $bills_detail_month_now->trash = $request->tienracinput;
            $bills_detail_month_now->internet = $request->tieninternetinput;
            $bills_detail_month_now->electricity_index = $request->electricity_index_new;
            $bills_detail_month_now->water_index = $request->water_index_new;
            $bills_detail_month_now->number_of_bike = $request->soxe;
            $bills_detail_month_now->room_rates = $request->tienphonginput;
            $bills_detail_month_now->owe = $request->conlai;
            $bills_detail_month_now->created_at = Carbon::now();
            $bills_detail_month_now->save();
            return redirect()->back()->withInput($request->input())
            ->withSuccess(trans('Cập nhật hoá đơn tháng thành công')); 
        }
    }
}