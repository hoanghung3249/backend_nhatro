<?php namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';

    public $timestamps = false;

    protected $guarded = [];
}
