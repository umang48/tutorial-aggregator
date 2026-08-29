<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('bookmarked')) {
            // Show only bookmarked articles
            $articles = Article::where('is_bookmarked', true)->latest('published_at')->paginate(10);
        } elseif ($request->filled('search')) {
            $articles = Article::search($request->search)->paginate(10);
        } else {
            $articles = Article::latest('published_at')->paginate(10);
        }

        return view('articles.index', compact('articles'));
    }

    public function toggleBookmark(Article $article)
    {
        $article->update(['is_bookmarked' => !$article->is_bookmarked]);
        
        return back(); // Send the user back to the page they were on
    }
}