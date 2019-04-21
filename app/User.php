<?php

namespace App;

use App\Notifications\PostCommented;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
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
        'email', 'username', 'first_name', 'last_name',
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

    public function subscriptions()
    {
        return $this->belongsToMany(Post::class, 'subscriptions'); // muchos a muchos
    }

    public function createPost(array $data)
    {
        $post = new Post($data);
        $this->posts()->save($post);
        $this->subscribeTo($post);
        return $post;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); //Un usuario tiene varios comentarios
    }

    //Verificar si un usuario está subscrito a un post
    public function isSubscribedTo(Post $post)
    {
        return $this->subscriptions()->where('post_id', $post->id)->count() > 0;
    }

    //
    public function subscribeTo(Post $post)
    {
        $this->subscriptions()->attach($post); //unir
    }

    public function unsubscribeFrom(Post $post)
    {
        $this->subscriptions()->detach($post); //separar
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

        // Notify subscribers
        Notification::send(
            $post->subscribers()->where('users.id', '!=', $this->id)->get(),
            new PostCommented($comment)
        );
        return $comment;
    }

    //si un usuario posee un modelo cualquiera
    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
