<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    echo 'about us';
});

Route::get('/main/{value}', [MainController::class , 'index']);
Route::get('/page2/{value}', [MainController::class , 'page2']);
Route::get('/page3/{value}', [MainController::class , 'page3']);
