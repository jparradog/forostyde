<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var Factory $factory */

use App\User;
use Illuminate\Database\Eloquent\Factory;

$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'email' => $faker->unique()->safeEmail,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->unique()->userName,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        //'pending' => $faker->boolean(),
        'pending' => true,
        'user_id' => function () { //se deja dentro de una funcion anonima para que solo se eejcute cuando no estamos personalizando.
            return factory(User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(\App\Category::class)->create()->id;
        },
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->paragraph,
        'post_id' => function () {
            return factory(\App\Post::class)->create()->id;
        },
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->sentence;
    return [
        'name' => $name,
        'slug' => str_slug($name),
    ];
});
