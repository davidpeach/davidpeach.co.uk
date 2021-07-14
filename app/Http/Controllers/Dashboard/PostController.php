<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('dashboard.posts.index', [
            'posts' => Post::all()
        ]);
    }

    public function update(Post $post, Request $request)
    {
        $post->update([
            'title' => $request->title,
            'body_raw' => $request->body_raw,
        ]);

        return redirect()->route('dashboard.post.index');
    }

    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'body_raw' => $request->body_raw,
        ]);

        return redirect()->route('post.show', ['post' => $post]);
    }
}
