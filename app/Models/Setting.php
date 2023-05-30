<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Setting extends Model
{
    use HasFactory;

    use HasRoles;

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
