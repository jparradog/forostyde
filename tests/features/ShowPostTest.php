<?php

use App\Post;
use App\User;

class ShowPostTest extends FeatureTestCase
{

    function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'first_name' => 'John',
            'last_name' => 'Parrado',
        ]);
        $post = $this->createPost([
            'title' => 'Este es el titulo del post',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id,
        ]);

        // dd(User::all()->toArray());

        // When
        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see('John Parrado');
    }

    function test_old_urls_are_redirected()
    {
        // Having
        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        $url = $post->url;
        $post->update(['title' => 'New title']);
        $this->visit($url)
            ->seePageIs($post->url);
    }
}
