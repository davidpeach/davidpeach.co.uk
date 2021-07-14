<?php

use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show'])->name('post.show');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('posts', [DashboardPostController::class, 'index'])->name('dashboard.post.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('posts', [PostController::class, 'store'])->name('post.store');
});

require __DIR__ . '/auth.php';
