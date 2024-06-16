<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ["user_id", "title", "media_id"];
    public function media()
    {
        return $this->belongsTo(Media::class,'media_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function reaction(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }
    public static function list($params){
        $list = self::query();
        
        if (isset($params['search']) && filled($params['search'])) {
            $list->where('title', 'LIKE', '%' . $params['search'] . '%')
            ;
        }
        return $list->get();
    }
    public static function store ($request, $id = null, $mediaId){

        $data = $request->only('title', 'media_id');
        if ($mediaId !== null) {
            $data['media_id'] = $mediaId;
        }
        $data = self::updateOrCreate([
            'id' => $id ,
            'user_id' => Auth()-> user() -> id
        ], $data);
        return $data;
    }
    public static function edit ($request, $id){
        $data = $request->only('title');
        $data = self::updateOrCreate(['id' => $id], $data);
        
        // echo Auth()-> user() -> id . "user update --";
        // echo $data->user_id . "user comment - ";
        return $data;
    }
    public static function destroy ($id){
        $data = self::find($id);
        $data->delete();
        return $data;
    }
}
