<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('index');
});
Route::get('/category/{category}', [CategoryController::class, 'show'])
     ->name('categories.show');
