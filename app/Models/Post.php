<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    const EXCERPT_LENGTH = 100;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'image',
        'description',
        'tags',
        'status',
    ];


    public function user()
    {
        /** @var TYPE_NAME $this */
        return $this->belongsTo(User::class);
    }

    public function excerpt(): string
    {
        return Str::limit($this->description, Post::EXCERPT_LENGTH);
    }

}
