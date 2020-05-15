<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    const INTERVAL_DAILY = 24;
    const INTERVAL_12_HOURS = 12;
    const INTERVAL_8_HOURS = 8;
    const INTERVAL_6_HOURS = 6;
    const INTERVAL_4_HOURS = 4;
    const INTERVAL_3_HOURS = 3;

    //
    protected $fillable = [
        'interval','user_id'
    ];

    protected $hidden = [
        'id', 'user_id','created_at','updated_at'
    ];
}
