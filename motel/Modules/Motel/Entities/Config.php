<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\Imgs;
use Carbon\Carbon;

class Config extends Model
{
    //use Translatable;

    protected $table = 'config';
    //public $translatedAttributes = [];
   //protected $fillable = ['name'];
   protected $guarded = [];

   	// public function getArea(){
   	// 	return $this->erea." m²";
   	// }
   	// public function getGiaPhong(){
   	// 	return number_format($this->unit_price,0,'.','.')." VNĐ";
   	// }
   	// public function getTienDien(){
   	// 	return number_format($this->payment_on_electricity,0,'.','.')."/KwH";
   	// }
   	// public function getTienNuoc(){
   	// 	return number_format($this->payment_of_water,0,'.','.')."/m³";
   	// }

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
   
   public function getUpdatedAt(){
      if($this->updated_at == "-0001-11-30 00:00:00" || $this->updated_at == null){
        return null;
      }return Carbon::parse($this->updated_at)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y');
   }
}