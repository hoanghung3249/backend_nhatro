<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
// use Modules\User\Entities\Sentinel\User;
use Modules\Motel\Entities\News;

class Imgs extends Model
{
    //use Translatable;

    protected $table = 'image';
   // public $translatedAttributes = [];
   // protected $fillable = [];
    protected $guard = [];


    public function news()
    {
        return $this->belongsTo(News::class);
    }

}
