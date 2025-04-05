<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/image/{slug}', [ImageController::class, 'show'])
    ->name('image.show');
Route::get('/download/{slug}', [ImageController::class, 'download'])->name('image.download');