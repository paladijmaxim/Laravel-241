<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Comment
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/articles/{article}/comments/create', [CommentController::class, 'create'])->name('comments.create');
Route::get('/comments', [CommentController::class, 'index'])->name('comment.index');
Route::get('/comments/{comment}/accept', [CommentController::class, 'accept'])->name('comment.accept');
Route::get('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comment.reject');

// Article
Route::resource('/article', ArticleController::class)->middleware('auth:sanctum');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show')->middleware('stat');

// Auth 
Route::get('/auth/signin', [AuthController::class, 'signin']);
Route::post('/auth/registr', [AuthController::class, 'registr']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
