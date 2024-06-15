<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['image', 'bio'];

    public static function list()
    {
        return self::all();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public static function destroyProfile($id)
    {
        $profile = self::find($id);

        if ($profile) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }
            $profile->delete();
        }

        return $profile;
    }
}
  