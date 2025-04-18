<?php
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/load-more', [HomeController::class, 'loadMore'])->name('home.loadMore');
Route::get('/category/', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/subcategory/{category}', [CategoryController::class, 'sub'])->name('categories.sub');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Search route (defined before image route to avoid conflicts)
Route::get('/search/{query}/', [SearchController::class, 'index'])->name('search');

// Image route
Route::get('/image/{slug}', [ImageController::class, 'show'])
    ->name('image.show');
Route::post('/image/{slug}/related', [ImageController::class, 'loadRelated'])->name('image.related');


// Image download route
Route::get('/download/{slug}', [ImageController::class, 'download'])->name('image.download');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/like-image', [LikeController::class, 'toggleLike'])->name('like.image');