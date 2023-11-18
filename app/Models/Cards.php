<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cards extends Model
{

    protected $table = 'cards';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('userID', 'typeCard', 'name', 'birthDate', 'gender','blood', 'location', 'phone', 'passcode', 'macAddress', 'picId');

}
