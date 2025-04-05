<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $galleryItems = Gallery::where('image_status', 1)
            ->where(function ($q) use ($query) {
                $q->where('tags', 'LIKE', "%{$query}%")
                  ->orWhere('image_name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with('database')
            ->paginate(20);

        $galleryItems->withPath("/search?q=" . urlencode($query));

        return view('search.index', compact('galleryItems', 'query'));
    }
}
