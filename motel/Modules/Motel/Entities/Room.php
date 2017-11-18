<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\Imgs;

class Room extends Model
{
    //use Translatable;

    protected $table = 'room';
    //public $translatedAttributes = [];
   //protected $fillable = ['name'];
   protected $guarded = [];

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

}