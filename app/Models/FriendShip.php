<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendShip extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['friend_id','user_id'];
    
}
