<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address_router',
        'username_router',
        'password_router',
    ];


    public function user()
    {
        /** @var TYPE_NAME $this */
        return $this->belongsTo(User::class);
    }
}
