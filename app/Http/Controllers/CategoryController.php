<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories with their databases
        $categories = Category::with('database')->get();

        // Return the view with the categories
        return view('categories.index', compact('categories'));
    }
    
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

        // Fetch ads for the category's db_id
        $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?cat='.$category->id);

        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }

        $ads = $this->fetchAdsForCount(count($galleryItems),$adInterval, $category->id);

        // Set the pagination path
        $galleryItems->withPath("/category/{$slug}/");

        // Return the view with the category, gallery items, and ads
        return view('categories.show', compact('category', 'galleryItems', 'ads', 'adInterval'));
    }

    protected function fetchAdsForCount($requiredCount, $adInterval, $categoryId)
    {
        // Calculate the required number of ads based on 1 ad for every 5 images
        $requiredAdsCount = ceil($requiredCount / $adInterval);

        $ads = [];

        // Fetch ads repeatedly until we have enough
        while (count($ads) < $requiredAdsCount) {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?cat='.$categoryId);

            if ($response->successful()) {
                $fetchedAds = $response->json()['ads'];

                // Merge fetched ads without duplicates
                $ads = array_merge($ads, $fetchedAds);
            }
        }

        // Trim the ads array to the required number of ads
        return array_slice($ads, 0, $requiredAdsCount);
    }
}

