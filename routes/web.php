<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;


// Article
Route::resource('/article', ArticleController::class)->middleware('auth:sanctum');

// Auth 
Route::get('/auth/signin', [AuthController::class, 'signin']);
Route::post('/auth/registr', [AuthController::class, 'registr']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);


// Main
Route::get('/', [MainController::class, 'index']);
Route::get('/full_image/{img}', [MainController::class, 'show']);


Route::get('/about', function () {
    return view('main.about');
});

Route::get('/contact', function () {
    $array = [
        'name' => 'Maksim',
        'address' => 'M. Semenovskaya h. 12',
        'email' => 'paladijmaxim@yandex.ru',
        'phone' => '+79950240915',
    ];
    return view('main.contact', ['contact' => $array]);
});