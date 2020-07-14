<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'text', 'author', 'active'
    ];

    protected $hidden = [
        'active','category_id'
    ];
}
