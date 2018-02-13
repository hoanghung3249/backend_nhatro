<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
// use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\News;
use Modules\Motel\Entities\Customer;
use Modules\Motel\Entities\Room;
use Modules\Motel\Entities\Bookings;
use Carbon\Carbon;

class Bills extends Model
{
    //use Translatable;

    protected $table = 'bills';
   // public $translatedAttributes = [];
   // protected $fillable = [];
    protected $guard = [];

    public function getBooking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id');
    }


   	public function getTotal(){
   		return number_format($this->total,0,'.','.')." VNĐ";
   	}

   	public function getNo(){
   		return number_format($this->owe,0,'.','.')." VNĐ";
   	}
   	public function getDaTra(){
   		return number_format($this->paid,0,'.','.')." VNĐ";
   	}

    public function getNgayTra(){
    	if($this->date_paid != null){
    		return Carbon::parse($this->date_paid)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y');
    	}return null;
    }
    public function getThang(){
      if($this->created_at != null){
        return Carbon::parse($this->created_at)->timezone('Asia/Ho_Chi_Minh')->format('m-Y');
      }      
    }
    public function getConLai(){
      $total = $this->total;
      $datra = $this->paid;
      $conlai = $total - $datra;
      return number_format($conlai,0,'.','.')."/VNĐ";
    }
}
