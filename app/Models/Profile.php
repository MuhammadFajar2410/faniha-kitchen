<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getUserName($user_id)
    {
        return Profile::with('user:id')->where('user_id', $user_id)->first();
    }

    public static function getAllUser()
    {
        return Profile::with('user:id,username,role,status')->orderBy('created_at', 'DESC')->paginate(10);
    }

    public static function getSingleProfile($user_id)
    {
        return Profile::where('user_id', $user_id)->first();
    }
}
