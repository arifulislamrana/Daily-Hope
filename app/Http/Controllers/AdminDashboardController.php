<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // Get summary of articles and users
    public function index()
    {
        $articleCount = Article::count();
        $userCount = User::count();

        return response()->json([
            'article_count' => $articleCount,
            'user_count' => $userCount,
        ]);
    }

    // Get recent articles for the dashboard
    public function recentArticles()
    {
        $articles = Article::with('author', 'category')
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($articles);
    }

    // Get list of users with their roles
    public function userList()
    {
        $users = User::select('id', 'name', 'email', 'role')->get();

        return response()->json($users);
    }

    // Get analytics or performance data (e.g., articles per month)
    public function analytics()
    {
        $articlesPerMonth = Article::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        return response()->json($articlesPerMonth);
    }
}

