<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
// use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\News;
use Modules\Motel\Entities\Bookings;
use Carbon\Carbon;



class Customer extends Model
{
    //use Translatable;

    protected $table = 'customer';
   // public $translatedAttributes = [];
   // protected $fillable = [];
    protected $guard = [];

    const NAM = 1;
    const NỮ = 2;

    public function getPhongTro(){
    	return $this->belongsTo(Bookings::class, 'booking_id');
    }
    public function getHoTen(){
    	return $this->full_name;
    }
    public function getEmail(){
    	return $this->email;
    }
    public function getDOB(){
    	return Carbon::parse($this->dob)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y');
    }
    public function getCMND(){
    	return $this->cmnd;
    }
    public function getGioiTinh(){
    	if($this->gender == self::NAM){
    		return "Nam";
    	}return "Nữ";
    }
    public function getNoiDKHKThuongTru(){
    	return $this->permanent_address;
    }
    public function getSDT(){
    	return $this->phone;
    }
    public function getNguyenQuan(){
    	return $this->birth_place;
    }
    public function getPhongDangO(){
    	$name_room = $this->getPhongTro()->first();
    	if($name_room != null){
    		return $name_room->getTenPhong();
    	}else{
    		return null;
    	}
    }
}
