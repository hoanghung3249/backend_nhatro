<?php

namespace Modules\Motel\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class News extends Model
{
    use Translatable;

    protected $table = 'news';
    public $translatedAttributes = [];
   // protected $fillable = [];
    protected $guard = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
