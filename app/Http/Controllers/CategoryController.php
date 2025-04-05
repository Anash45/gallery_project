<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();
        return view('categories.show', compact('category'));
    }
}
