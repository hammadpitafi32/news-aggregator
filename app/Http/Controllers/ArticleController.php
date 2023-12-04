<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query();

        // Filter by search query
        if ($request->has('search')) {
            $search = $request->input('search');
            $articles->where('title', 'like', "%$search%")
                     ->orWhere('description', 'like', "%$search%")
                     ->orWhere('content', 'like', "%$search%");
        }

        // Add other filters as needed (e.g., category, source, date)

        // Retrieve the articles
        $result = $articles->paginate(10);

        return response()->json($result);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        return response()->json($article);
    }
}
