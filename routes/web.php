<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Wrap your app routes in auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('home');
    Route::patch('/articles/{article}/bookmark', [ArticleController::class, 'toggleBookmark'])->name('articles.bookmark');
    Route::patch('/articles/{article}/draft', [ArticleController::class, 'saveDraft'])->name('articles.draft');
});

require __DIR__.'/auth.php';
