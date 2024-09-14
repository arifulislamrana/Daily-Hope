<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminDashboardController;

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Public Routes
Route::prefix('articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index']);
    Route::get('{id}', [ArticleController::class, 'show']);
    Route::post('comments', [CommentController::class, 'store']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);
});

// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('user', [UserController::class, 'show']);

    // Article Management (Editors)
    Route::middleware('ensureEditor')->prefix('articles')->group(function () {
        Route::post('/', [ArticleController::class, 'store']);
        Route::put('{id}', [ArticleController::class, 'update']);
        Route::delete('{id}', [ArticleController::class, 'destroy']);
    });

    // Article Reactions & Tags
    Route::prefix('articles')->group(function () {
        Route::post('{id}/react', [ArticleController::class, 'react']);
        Route::post('{id}/tags', [ArticleController::class, 'addTags']);
        Route::get('trending', [ArticleController::class, 'trending']);
    });

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::put('{id}/read', [NotificationController::class, 'markAsRead']);
    });

    // Admin Routes
    Route::middleware('ensureAdmin')->group(function () {
        // User Management
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('top-fans', [UserController::class, 'topFans']);
            Route::get('top-editors', [UserController::class, 'topEditors']);
        });

        // Admin Dashboard
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index']);
            Route::get('recent-articles', [AdminDashboardController::class, 'recentArticles']);
            Route::get('users', [AdminDashboardController::class, 'userList']);
            Route::get('analytics', [AdminDashboardController::class, 'analytics']);
        });

        // Article Approval and Archiving
        Route::prefix('articles')->group(function () {
            Route::put('{id}/approve', [ArticleController::class, 'approve']);
            Route::put('{id}/archive', [ArticleController::class, 'archive']);
        });
    });
});
