<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::orderBy('published_at', 'desc')->where('status', 'live')->get(),
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status === 'draft') {
            abort(404);
        }

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
