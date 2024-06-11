<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,  SoftDeletes;
    protected $fillable = ['user_id', 'post_id', 'comment'];
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public static function store($request, $id = null){
        $data = $request->only('user_id', 'post_id', 'comment');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
        
    }
}
