<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'content',
    ];

    // obligamos a que en bd sea de tipo boolean
    protected $casts = [
        'pending' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); //Un post tiene un usuario
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); //Un post tiene varios comentarios
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute() //creamos un atributo dinamico url
    {
        return route('posts.show', [$this->id, $this->slug]);
    }
}
