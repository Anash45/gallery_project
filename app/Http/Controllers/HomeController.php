<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use App\Models\Ad; // Import the Ad model
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Check if cached images for recently added exist and if they are still valid (within 24 hours)
        $recentImages = Cache::remember('recent_images', 60 * 24, function () {
            // If not cached or cache expired, fetch 12 random images
            return Gallery::where('image_status', 1)
                ->inRandomOrder()  // Randomly fetch images
                ->take(14)  // Limit to 12 images
                ->get();
        });

        // Get all categories with their latest 8 approved images (custom query without Eloquent relation)
        $categories = Category::all(); // Get all categories

        // Fetch ads for the "recently added" section (randomly from all db_ids)
        $recentAds = Ad::inRandomOrder()->take(2)->get(); // Fetch 2 random ads

        foreach ($categories as $category) {
            // Custom query to get 8 most recent images for each category
            $category->galleryItems = Gallery::where('cat_id', $category->source_cid)
                ->where('db_id', $category->db_id)
                ->where('image_status', 1)
                ->inRandomOrder()
                ->take(7)
                ->get();

            // Fetch ads for each category based on db_id
            $category->ads = Ad::where('db_id', $category->db_id)->inRandomOrder()->take(2)->get();
        }

        return view('home', compact('recentImages', 'categories', 'recentAds'));
    }
}
