<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class CreatePostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $post = new Post($request->all()); //instanciamos un nuevo post
        auth()->user()->posts()->save($post); // lo asignamos a un usuario
        return $post->title;
    }
}