<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
// use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\News;
use Modules\Motel\Entities\Customer;
use Modules\Motel\Entities\Room;
use Carbon\Carbon;

class Bookings extends Model
{
    //use Translatable;

    protected $table = 'booking';
   // public $translatedAttributes = [];
   // protected $fillable = [];
    protected $guard = [];

   	public function getGiaPhong(){
   		return number_format($this->unit_price,0,'.','.')." VNĐ";
   	}

   	public function getTienDien(){
   		return number_format($this->payment_on_electricity,0,'.','.')."/KwH";
   	}
   	public function getTienNuoc(){
   		return number_format($this->payment_of_water,0,'.','.')."/m³";
   	}

   	public function getTienCoc(){
    	return number_format($this->deposit,0,'.','.')." VNĐ";
    }


    public function getCustomer(){
    	return $this->hasMany(Customer::class, 'customer_id');
    }
   	// public function getTenKhachHang(){
    // 	$name_client = $this->getCustomer()->first();
    // 	if($name_client != null){
    // 		return $name_client->full_name;
    // 	}else{
    // 		return null;
    // 	}
    // }


   	public function getPhong(){
    	return $this->belongsTo(Room::class, 'room_id');
    }
   	public function getTenPhong(){
    	$name_room = $this->getPhong()->first();
    	if($name_room != null){
    		return $name_room->name;
    	}else{
    		return null;
    	}
    }

    public function getNgaythue(){
    	if($this->start_date != null){
    		return Carbon::parse($this->start_date)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y');
    	}return null;
    	
    }
    public function getNgaytra(){
    	if($this->end_date != null){
    		return Carbon::parse($this->end_date)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y');
    	}return null;
    }
}
