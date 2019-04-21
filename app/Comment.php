<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Comment extends Model
{
    protected $fillable = ['comment', 'post_id'];
    public function post()
    {
        return $this->belongsTo(Post::class); //Un Comentario pertenece a un post
    }

    //Marcar como resuelto un post
    public function markAsAnswer()
    {
        $this->post->pending = false;
        $this->post->answer_id = $this->id;
        $this->post->save();
    }
    //Atributo dinamico
    public function getAnswerAttribute()
    {
        return $this->id === $this->post->answer_id;
    }
}
