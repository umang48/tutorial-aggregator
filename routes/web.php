<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::patch('/articles/{article}/bookmark', [ArticleController::class, 'toggleBookmark'])->name('articles.bookmark');