<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // If the user types in the search bar, use Laravel Scout
        if ($request->filled('search')) {
            $articles = Article::search($request->search)->paginate(10);
        } else {
            // Otherwise, show the latest trending articles
            $articles = Article::latest('published_at')->paginate(10);
        }

        return view('articles.index', compact('articles'));
    }
}