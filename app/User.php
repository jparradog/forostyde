<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class); //un usuario puede tener muchos posts
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); //Un usuario tiene varios comentarios
    }

    /**
     * Guardar un comentario sabiendo el post al que pertenece y desde luego el usuario que lo creó
     * @param Post $post
     * @param $message
     */
    public function comment(Post $post, $message)
    {
        $comment = new Comment([
            'comment' => $message,
            'post_id' => $post->id,
        ]);
        $this->comments()->save($comment);
    }

    //si un usuario posee un modelo cualquiera
    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }
}
