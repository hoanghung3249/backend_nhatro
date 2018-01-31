<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\Imgs;
use Modules\Motel\Entities\Bookings;

class Room extends Model
{
    //use Translatable;

    protected $table = 'room';
    //public $translatedAttributes = [];
   //protected $fillable = ['name'];
   protected $guarded = [];


    public function getBooking(){
      return $this->hasMany(Bookings::class, 'room_id','id');
    }

   	public function getArea(){
   		return $this->erea." m²";
   	}
   	public function getGiaPhong(){
   		return number_format($this->unit_price,0,'.','.')." VNĐ";
   	}
   	public function getTienDien(){
   		return number_format($this->payment_on_electricity,0,'.','.')."/KwH";
   	}
   	public function getTienNuoc(){
   		return number_format($this->payment_of_water,0,'.','.')."/m³";
   	}
    public function checkPhongThue(){
    //   $data = Bookings::where('room_id',$room_id)->first();
    //   if($data){
    //     return false;
    //   }return true;

      $room = self::getBooking()->count();
      //dd($room);
      if($room > 0){
        return false;
      }
      return true;


    }

}