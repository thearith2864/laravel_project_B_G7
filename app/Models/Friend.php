<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Friend extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','email'];
    public static function list(){
       $friend= self::all();  
       return $friend;

    }
    public static function store ($request, $id = null){
        $data = $request->only('name','email');
        $data = self::updateOrCreate(['id' => $id], $data);
        return $data;
    }
    public static function show($id){
        $friend = self::find($id);
        return $friend;
    }
    public static function destroy($id){
        $friend = self::find($id);
        $friend->delete();
        return $friend;
    }
}
