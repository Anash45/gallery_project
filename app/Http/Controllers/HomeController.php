<?php

namespace App\Http\Controllers;

use App\Helpers\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Gallery;
use Illuminate\Support\Facades\Cache;
use App\Models\Search;

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

        if (PlatformHelper::isAndroid()) {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=android');
        } else {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=other');
        }



        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }

        // Fetch enough ads from the external API
        $recentAds = $this->fetchAdsForCount(count($recentImages), $adInterval);

        // Get top 10 trending searches (most searched)
        $trendingSearches = Search::orderBy('count', 'desc')
            ->limit(10)
            ->pluck('query');

        return view('home', compact('recentImages', 'recentAds', 'adInterval', 'trendingSearches'));
    }


    public function loadMore(Request $request)
    {
        $offset = $request->input('offset', 0);
        $loadedIds = $request->input('loadedIds', []); // Get already loaded IDs (array)

        // Load next 20 random images, excluding already loaded ones
        $query = Gallery::where('image_status', 1);

        if (!empty($loadedIds)) {
            $query->whereNotIn('central_id', $loadedIds);
        }

        $images = $query->inRandomOrder()
            ->take(20)
            ->get();

        if (PlatformHelper::isAndroid()) {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=android');
        } else {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=other');
        }

        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }

        $ads = $this->fetchAdsForCount(count($images), $adInterval);

        $html = view('partials.image_with_ads', [
            'recentImages' => $images,
            'recentAds' => $ads,
            'adInterval' => $adInterval
        ])->render();

        return response()->json(['html' => $html, 'newLoadedIds' => $images->pluck('central_id')]);
    }


    protected function fetchAdsForCount($requiredCount, $adInterval)
    {
        // Calculate the required number of ads based on 1 ad for every 5 images
        $requiredAdsCount = ceil($requiredCount / $adInterval);

        $ads = [];

        // Fetch ads repeatedly until we have enough
        while (count($ads) < $requiredAdsCount) {

            if (PlatformHelper::isAndroid()) {
                $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=android');
            } else {
                $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=other');
            }

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
