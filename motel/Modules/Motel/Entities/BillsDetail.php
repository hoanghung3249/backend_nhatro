<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
// use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\News;
use Modules\Motel\Entities\Customer;
use Modules\Motel\Entities\Room;
use Modules\Motel\Entities\Bills;
use Modules\Motel\Entities\Bookings;
use Carbon\Carbon;

class BillsDetail extends Model
{
    //use Translatable;

    protected $table = 'bills_detail';
   // public $translatedAttributes = [];
   // protected $fillable = [];
    protected $guard = [];

    public function getBills(){
      return $this->belongsTo(Bills::class, 'bills_id');
    }



    public function getGiaPhong(){
      return number_format($this->room_rates,0,'.','.')." VNĐ";
    }
    public function getTienDien(){
      return number_format($this->payment_on_electricity,0,'.','.')."/KwH";
    }
    public function getTienNuoc(){
      return number_format($this->payment_of_water,0,'.','.')."/m³";
    }
    public function getTienRac(){
      return number_format($this->trash,0,'.','.')." VNĐ";
    }
    public function getTienInternet(){
      return number_format($this->internet,0,'.','.')." VNĐ";
    }
    public function getTienDauXe(){
      return number_format($this->parking,0,'.','.')." VNĐ";
    }
    public function getSoLuongXe(){
      return $this->number_of_bike."/chiếc";
    }

   	public function getChiSoNuoc(){
   		return $this->water_index;
   	}

   	public function getChiSoDien(){
   		return $this->electricity_index;
   	}
}
