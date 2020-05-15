<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeQuote extends Model
{
    //
    protected $hidden = [
        'user_id','quote_id'
    ];
}
