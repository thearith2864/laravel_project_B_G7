<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["user_id", "post_id", "type_react",];
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public static function store($request, $id = null){
        $data = $request->only('user_id', 'post_id', 'type_react');
        $data = self::updateOrCreate([
            'id' => $id,
            'user_id' => Auth()-> user() -> id
    ], $data);
        return $data;
        
    }
    public static function updateReaction ($request, $id){
        $data = $request->only("user_id",'type_react');
        $data = self::updateOrCreate([
            'id' => $id,
            'user_id' => Auth()-> user() -> id  
        ], $data);
        return $data;
    }
    public static function destroyReaction ($id){
        $data = self::find($id);
        $data->delete();
        return $data;
    }
}
