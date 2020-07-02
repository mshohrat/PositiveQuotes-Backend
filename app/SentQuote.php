<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SentQuote extends Model
{
    //
    protected $hidden = [
        'user_id','quote_id'
    ];

    protected $fillable = [
        'user_id','quote_id'
    ];
}
