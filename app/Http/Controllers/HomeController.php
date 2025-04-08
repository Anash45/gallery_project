<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


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
                ->take(50)  // Limit to 12 images
                ->get();
        });


        // Fetch ads for the "recently added" section (randomly from all db_ids)
        $recentAds = Ad::inRandomOrder()->get(); // Fetch 2 random ads


        return view('home', compact('recentImages', 'recentAds'));
    }

    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 0);

        // Load next 30 images
        $images = Gallery::where('image_status', 1)
            ->orderBy('central_id', 'desc')
            ->skip($offset)
            ->take(30)
            ->get();

        $ads = Ad::inRandomOrder()->get();

        // Render partial and return as JSON
        $html = view('partials.image_with_ads', [
            'recentImages' => $images,
            'recentAds' => $ads
        ])->render();

        return response()->json(['html' => $html]);
    }

}
