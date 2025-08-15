<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about']);
Route::get('/services', [HomeController::class, 'services']);
Route::get('/works', [HomeController::class, 'works']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/blog', [HomeController::class, 'blog']);