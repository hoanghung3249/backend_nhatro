<?php

namespace Modules\Motel\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Motel extends Model
{
    use Translatable;

    protected $table = 'motel__motels';
    public $translatedAttributes = [];
    protected $fillable = [];
}
