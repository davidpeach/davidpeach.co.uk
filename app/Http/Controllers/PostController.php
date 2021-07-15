<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::orderBy('published_at', 'desc')->where('status', 'live')->where('published_at', '<=', now())->get(),
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status === 'draft') {
            abort(404);
        }

        if ($post->published_at > now()) {
            abort(404);
        }

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
