<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['user_id','image', 'name','email'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

   public static function list(){
        return self::all();
 
   }
    public static function store($request, $id=null){
        $date = $request->only('user_id', 'image', 'name', 'email');
        $date = self::updateOrCreate(['id' => $id], $date);
        return $date;
    }
    public static function destroy($id)
    {
        $data = self::find($id);
        $data->delete();
        return $data;
    }
}
