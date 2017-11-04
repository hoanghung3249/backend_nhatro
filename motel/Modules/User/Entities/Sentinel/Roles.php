<?php namespace Modules\User\Entities\Sentinel;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';

    public $timestamps = false;

    protected $guarded = [];
}
