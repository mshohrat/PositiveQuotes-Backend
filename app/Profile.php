<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    const GENDER_UNKNOWN = 0;
    const GENDER_MAIL = 1;
    const GENDER_WOMAN = 2;
    //

    protected $fillable = [
        'name','email','gender','user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id','id','created_at','updated_at'
    ];
}
