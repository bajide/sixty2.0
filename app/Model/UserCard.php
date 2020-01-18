<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    protected $table = 'user_cards';
    protected $fillable = [];

    /*--------------------relations--------------------*/
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
