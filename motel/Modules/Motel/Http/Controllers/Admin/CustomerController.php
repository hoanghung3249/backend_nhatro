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
use Modules\Motel\Http\Requests\CreateCustomerRequest;
use Modules\Motel\Http\Requests\UpdateCustomerRequest;
use Auth;
use Modules\User\Contracts\Authentication;
use Carbon\Carbon;

class CustomerController extends AdminBaseController
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

        return view('motel::admin.customer.index');
	}
    public function indextable(){
            $currentUser = $this->auth->user()->id;
            $items = Customer::where('user_id',$currentUser)->get();
            //dd($items);
            $collection = collect($items);
            return $this->datatables->of($collection)
                    ->editColumn('tenphong', function( $item) {
                                return $item->getPhongDangO();
                            })
                    ->editColumn('fullname', function( $item) {
                                return $item->getHoTen();
                            })
                    ->editColumn('dob', function( $item) {
                                return $item->getDOB();
                            })
                    ->editColumn('gender', function( $item) {
                                return $item->getGioiTinh();
                            })
                    ->editColumn('phone', function( $item) {
                                return $item->getSDT();
                            })
                    // ->addColumn('select', function(Room $room) {
                 //         if($room->status==1){
                 //             return '<div id="check'.$room->id.'" class="check-stt" data-value="'.$room->id.'" status="1">
                    //      <span class="label label-success" style="cursor: pointer; padding:7px" >Còn trống</span></div>';
                 //         }else{
                 //             return '<div id="check'.$room->id.'" class="check-stt" data-value="'.$room->id.'" status="0">
                    //      <span class="label label-danger" style="cursor: pointer; padding:7px" >Đang thuê</span></div>';
                 //         }
                    //  })
                    ->addColumn('check', '<input class = "check" type="checkbox" name="selected_room[]" value="{{ $id }}">')
                    ->addColumn('button', '<div class ="button_action">
                                <a title=Edit Room" class="btn btn-default btn-flat chitiet" idcus="{{$id}}" href="javascript:void(0)" style="margin-right:3px"><i class="fa fa-eye"></i></a> 
                                <button title="Delete Room" class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{route("admin.customer.customer.delete",$id)}}"><i class="fa fa-trash"></i></button> </div>
                                ')
                    ->rawColumns(['check', 'action','button','select'])->make(true);
    }
    public function getCustomerDetail(Request $request){
        $currentUser = $this->auth->user()->id;
        $idcus = $request->get('idcus');

        $info_customer = Customer::where('id',$idcus)->where('user_id',$currentUser)->first();
        return view('motel::admin.partials.detail_cus',compact('info_customer'))->render();        
    }
    public function create(){
        return view('motel::admin.customer.create');
    }
    public function store(CreateCustomerRequest $request){
        //dd($request->all());
        $currentUser = $this->auth->user()->id;
        $date = Carbon::parse($request->dob)->format('Y-m-d');
        $data = new Customer();
        $data->full_name = $request->full_name;
        $data->email = $request->email;
        $data->dob = $date;
        $data->cmnd = $request->cmnd;
        $data->gender = $request->gender;
        $data->phone = $request->phone;
        $data->birth_place = $request->birth_place;
        $data->user_id = $currentUser;
        $data->permanent_address = $request->permanent_address;
        //dd($data);
        $data->save();
        return redirect()->route('admin.customer.customer.index')
            ->withSuccess(trans('Tạo mới thành công')); 
    }
    public function edit($id){
        $cus = Customer::find($id);
        if(!$cus){
            abort(404);
        }else{
            return view('motel::admin.customer.edit',compact('cus'));
        }
    }
    public function update(UpdateCustomerRequest $request, $id){
        $date = Carbon::parse($request->dob)->format('Y-m-d');
        $data = Customer::find($id);
        $data->full_name = $request->full_name;
        $data->email = $request->email;
        $data->dob = $date;
        $data->cmnd = $request->cmnd;
        $data->gender = $request->gender;
        $data->phone = $request->phone;
        $data->birth_place = $request->birth_place;
        $data->permanent_address = $request->permanent_address;
        $data->save();
        return redirect()->back()
            ->withSuccess(trans('Chỉnh sửa thành công'));
    }
    public function delete(Request $request, $id){
        $cus = Customer::find($id);
        if($cus){
            $cus->delete();
            return redirect()->route('admin.customer.customer.index')
            ->withSuccess(trans('Xoá thành công'));
        }abort(404);

    }
    public function bulkDelete(Request $request){
        $id = [];
        $id = $request->selected_room;
        //dd($id);
        if($id == null){
            return redirect()->back()
                    ->withWarning(trans('Bạn phải chọn mục cần xoá'));
        }else{
            foreach( $id as $item ){
                $cus = Customer::find($item);
                $cus->delete();
            }return redirect()->back()
                    ->withSuccess(trans('Xoá thành công'));
        }

    }
}