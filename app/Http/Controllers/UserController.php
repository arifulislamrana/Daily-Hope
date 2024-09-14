<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Get Top Fans
    public function topFans()
    {
        $topFans = User::withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($topFans);
    }

    public function topEditors()
    {
        $topEditors = User::whereHas('roles', function ($query) {
            $query->where('name', 'editor');
        })
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($topEditors);
    }
}

