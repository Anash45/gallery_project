<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Gallery;
use App\Models\Ad;

class SearchController extends Controller
{
    public function index(Request $request, $query)
    {
        $query = urldecode($query);
        $sort = $request->get('sort', 'newest'); // Default to newest

        $galleryQuery = Gallery::where('image_status', 1)
            ->where(function ($q) use ($query) {
                $q->where('tags', 'LIKE', "%{$query}%")
                    ->orWhere('image_name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with('database');

        // Apply sorting
        switch ($sort) {
            case 'most_viewed':
                $galleryQuery->orderByDesc('view_count');
                break;
            case 'most_downloaded':
                $galleryQuery->orderByDesc('download_count');
                break;
            case 'az':
                $galleryQuery->orderBy('image_name', 'asc');
                break;
            case 'za':
                $galleryQuery->orderBy('image_name', 'desc');
                break;
            case 'newest':
            default:
                $galleryQuery->orderByDesc('central_id');
                break;
        }

        $galleryItems = $galleryQuery->paginate(20);
        $galleryItems->withPath("/search/" . urlencode(str_replace(' ', '+', $query)) . "/")->appends(['sort' => $sort]);

        // Ads logic
        $response = Http::get('https://electricaapps.top/ads/api/ad_api.php');
        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }
        $ads = $this->fetchAdsForCount(count($galleryItems), $adInterval);

        // Tags logic
        $allTags = $galleryItems->pluck('tags')->flatten()->toArray();
        $tagArray = [];
        foreach ($allTags as $tags) {
            $tagArray = array_merge($tagArray, explode(',', $tags));
        }
        $tagArray = array_map('trim', $tagArray);

        $matchingTags = array_filter($tagArray, function ($tag) use ($query) {
            return stripos($tag, $query) !== false;
        });

        $uniqueTags = array_unique($tagArray);
        $matchingTags = array_unique(array_map('trim', $matchingTags));
        $finalTags = array_merge($matchingTags, array_diff($uniqueTags, $matchingTags));
        $finalTags = array_slice($finalTags, 0, 12);

        return view('search.index', compact('galleryItems', 'query', 'ads', 'adInterval', 'finalTags', 'sort'));
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
