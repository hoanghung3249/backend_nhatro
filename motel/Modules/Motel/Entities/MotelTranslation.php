<?php

namespace Modules\Motel\Entities;

use Illuminate\Database\Eloquent\Model;

class MotelTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'motel__motel_translations';
}
