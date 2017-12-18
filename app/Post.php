<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    protected $with = ['user', 'tags'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userLike(){
        return $this->belongsToMany(User::class, 'user_like_post');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
