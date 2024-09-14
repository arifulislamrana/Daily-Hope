<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Reaction;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author', 'category')->latest()->paginate(10);
        return response()->json($articles);
    }

    public function show($id)
    {
        $article = Article::with('author', 'category', 'comments')->findOrFail($id);
        return response()->json($article);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->get("content"),
            'author_id' => Auth::id(),
            'category_id' => $request->category_id,
            'published_at' => $request->published_at,
        ]);

        return response()->json($article, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $article = Article::findOrFail($id);
        $article->update($request->all());

        return response()->json($article);
    }

    public function destroy($id)
    {
        Article::destroy($id);
        return response()->json(null, 204);
    }

    public function approve(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Check if the user is an admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $article->status = 'approved';
        $article->save();

        return response()->json($article);
    }

    // Archive an article
    public function archive(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        // Check if the user is an admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $article->archived_at = now();
        $article->save();

        return response()->json($article);
    }

    public function react(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reaction_type' => 'required|in:like,love,angry,sad', // Define allowed reaction types
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $article = Article::findOrFail($id);
        $reaction = Reaction::updateOrCreate(
            ['user_id' => auth()->id(), 'article_id' => $article->id],
            ['reaction_type' => $request->reaction_type]
        );

        return response()->json($reaction);
    }

    // Add Tags to Article
    public function addTags(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $tags = $request->input('tags', []);

        $tags = array_map('trim', $tags);
        $tags = array_unique($tags);

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->syncWithoutDetaching($tag->id);
        }

        return response()->json($article->tags);
    }

    // Get Trending Articles
    public function trending()
    {
        $articles = Article::withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($articles);
    }
}

