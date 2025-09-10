<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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