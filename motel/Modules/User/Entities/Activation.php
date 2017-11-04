<?php namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    protected $table = 'activations';

    public $timestamps = true;

    protected $guarded = [];
}
