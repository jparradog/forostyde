<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'content', 'category_id'
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

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Ultimos comentarios
    public function latestComments()
    {
        return $this->comments()->orderBy('created_at', 'DESC');
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

    public function getSafeHtmlContentAttribute()
    {
        return Markdown::convertToHtml(e($this->content));
    }
}
