<?php

//Rutas que requieren autenticación

// Posts
Route::get('posts/create', [
    'uses' => 'CreatePostController@create', //llama al metodo...
    'as' => 'posts.create', //nombre de la ruta
]);

Route::post('posts/create', [
    'uses' => 'CreatePostController@store',
    'as' => 'posts.store',
]);
