<?php
/**
 * summary
 */
class CreatePostsTest extends FeatureTestCase
{
    /**
     * summary
     */
    public function test_a_user_create_a_post()
    {
        // having - Teniendo
        $user = $this->defaultUser();
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';
        $pending = true;

        $this->actingAs($user) //simula que el usuario esté conectado
        //When - Cuando
             ->Visit(route('posts.create')) //visitamos la ruta
             ->type($title, 'title') //Escribir en un campo
             ->type($content, 'content')
             ->press('Publicar'); // presionar boton

        // Then - Entonces
        // ver en BD
        $this->seeInDatabase('posts', [
            'title' => $title,
            'content' => $content,
            'pending' => $pending,
            'user_id' => $user->id,
            'slug' => 'esta-es-una-pregunta',
        ]);

        // verificamos si fue redirigido a otra url
        // $this->seeInElement('hi', $title); //verificar etiqueta h1 si tiene un texto
        $this->see($title); //solo ver el texto
    }

    public function test_creating_a_post_requires_autentication()
    {

        //When - Cuando
        $this->Visit(route('posts.create'));

        // Then - Entonces
        $this->seePageIs(route('login'));
    }

    function test_create_post_form_validation($value='')
    {
        $this->actingAs($this->defaultUser()) //conectandonos
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ]);
    }
}
