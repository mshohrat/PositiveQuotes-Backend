<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'text', 'author', 'active'
    ];

    protected $hidden = [
        'active'
    ];

    public function usersReceived() {
        return $this->belongsToMany(User::class,'sent_quotes');
    }

    public function likedUsers() {
        return $this->belongsToMany(User::class,'like_quotes');
    }
}
