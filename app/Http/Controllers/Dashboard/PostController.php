<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
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
        $publishDate = new Carbon($request->published_at);

        $post->update([
            'title' => $request->title,
            'body_raw' => $request->body_raw,
            'status' => $request->status,
            'published_at' => $publishDate,
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
        $now = now();

        return view('dashboard.posts.create', [
            'currentDateTime' => parseDateForHtmlInput($now),
        ]);
    }

    public function store(Request $request)
    {
        $publishDate = new Carbon($request->published_at);

        $post = Post::create([
            'title' => $request->title,
            'body_raw' => $request->body_raw,
            'status' => $request->status,
            'slug' => makePostSlug($publishDate, $request->title),
            'published_at' => $publishDate,
        ]);

        if ($post->status === 'draft') {
            return redirect()->route('dashboard.post.edit', ['post' => $post]);
        }

        return redirect()->route('post.show', ['post' => $post->slug]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('dashboard.post.index');
    }
}
