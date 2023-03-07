<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'avatar',
    ];


//    public function user(){
//        return $this->belongsTo(User::class);
//    }
//    public static function findOrfail($id)
//    {
//    }
}
