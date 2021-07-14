<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('dashboard.posts.index', [
            'posts' => Post::all()
        ]);
    }
}
