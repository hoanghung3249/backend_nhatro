<?php

namespace Modules\Motel\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class MappingNewsUser extends Model
{
    //use Translatable;

    protected $table = 'mapping_news_users';
    //public $translatedAttributes = [];
   	// protected $fillable = ['sub_image','sub_image_thumb'];
   protected $guarded = [];


}
