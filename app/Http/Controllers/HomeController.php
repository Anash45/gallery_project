<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        // Check if cached images for recently added exist and if they are still valid (within 24 hours)
        $recentImages = Cache::remember('recent_images', 60 * 24, function () {
            // If not cached or cache expired, fetch 12 random images
            return Gallery::where('image_status', 1)
                ->inRandomOrder()  // Randomly fetch images
                ->take(12)  // Limit to 12 images
                ->get();
        });

        // Get all categories with their latest 8 approved images (custom query without Eloquent relation)
        $categories = Category::all(); // Get all categories

        foreach ($categories as $category) {
            // Custom query to get 8 most recent images for each category
            $category->galleryItems = Gallery::where('cat_id', $category->source_cid)
                ->where('db_id', $category->db_id)
                ->where('image_status', 1)
                ->inRandomOrder()
                ->take(8)
                ->get();
        }

        return view('home', compact('recentImages', 'categories'));
    }


}
