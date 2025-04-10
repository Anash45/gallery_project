<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Gallery;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache the recently added images (valid for 24 hours)
        $recentImages = Cache::remember('recent_images', 60 * 24, function () {
            return Gallery::where('image_status', 1)
                ->inRandomOrder()
                ->take(30)
                ->get();
        });

        $response = Http::get('https://electricaapps.top/ads/api/ad_api.php');

        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }

        // Fetch enough ads from the external API
        $recentAds = $this->fetchAdsForCount(count($recentImages), $adInterval);

        return view('home', compact('recentImages', 'recentAds', 'adInterval'));
    }


    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 0);

        // Load next 30 images
        $images = Gallery::where('image_status', 1)
            ->orderBy('central_id', 'desc')
            ->skip($offset)
            ->take(20)
            ->get();


        $response = Http::get('https://electricaapps.top/ads/api/ad_api.php');

        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }

        // Fetch enough ads for 30 images
        $ads = $this->fetchAdsForCount(count($images),$adInterval);

        // Render partial and return as JSON
        $html = view('partials.image_with_ads', [
            'recentImages' => $images,
            'recentAds' => $ads,
            'adInterval' => $adInterval
        ])->render();

        return response()->json(['html' => $html]);
    }


    protected function fetchAdsForCount($requiredCount, $adInterval)
    {
        // Calculate the required number of ads based on 1 ad for every 5 images
        $requiredAdsCount = ceil($requiredCount / $adInterval);

        $ads = [];

        // Fetch ads repeatedly until we have enough
        while (count($ads) < $requiredAdsCount) {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php');

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
