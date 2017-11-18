<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\Imgs;

class News extends Model
{
    //use Translatable;

    protected $table = 'news';
    //public $translatedAttributes = [];
   	// protected $fillable = ['sub_image','sub_image_thumb'];
   protected $guard = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function image(){
    	return $this->hasMany(Imgs::class, 'new_id');
    }

}
