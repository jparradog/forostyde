<?php

class ExampleTest extends FeatureTestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
            'name' => 'John Parrado',
            'email' => 'japarradog@gmail.com',
        ]);
        // DD($user);
        $this->actingAs($user, 'api')
             ->visit('api/user')
             // ->see($user->name);
             ->see('John Parrado')
             ->see('japarradog@gmail.com');
    }
}
