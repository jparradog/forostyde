<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
        // creamos el post
        $post = $this->createPost();
        // Traemos el usuario
        $user = $this->defaultUser();
        //Simulamos que el usuario esté conectado
        $this->actingAs($user)
            //vamos a la url del post
            ->visit($post->url)
            ->type('Un comentario', 'comment')
            ->press('Publicar comentario');
        // miramos en la bd si se guardó
        $this->seeInDatabase('comments', [
            'comment' => 'Un comentario',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        // si nos envió a la url del post
        $this->seePageIs($post->url);
    }
}
