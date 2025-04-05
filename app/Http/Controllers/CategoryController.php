<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // Get the category with its database
        $category = Category::whereSlug($slug)
            ->with('database')
            ->firstOrFail();

        // Fetch gallery images where:
        // - cat_id = category's source_id
        // - db_id = category's db_id
        // - image_status = 1
        $galleryItems = Gallery::where('cat_id', $category->source_cid)
            ->where('db_id', $category->db_id)
            ->where('image_status', 1)
            ->with('database')
            ->paginate(20);

        // Set the pagination path
        $galleryItems->withPath("/category/{$slug}/");

        // Return the view with the category and gallery items
        return view('categories.show', compact('category', 'galleryItems'));
    }
}
