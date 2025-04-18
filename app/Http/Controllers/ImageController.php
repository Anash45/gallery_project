<?php

namespace App\Http\Controllers;

use App\Helpers\PlatformHelper;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function show($slug)
    {
        // Fetch the image using the slug and eager load the database relationship
        $image = Gallery::where('slug', $slug)
            ->with('database')
            ->firstOrFail();

        $image->increment('view_count');

        // Fetch the category using the cat_id from the image
        $category = Category::where('source_cid', $image->cat_id)
            ->where('db_id', $image->db_id)
            ->first();

        // Extract related tags for future use
        $relatedTags = collect(explode(',', $image->tags))
            ->map(fn($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values();

        // Get categories from other databases (exclude this image's db)
        $otherCategories = Category::where('db_id', '!=', $image->db_id)->get()->take(3);

        return view('image.show', compact('image', 'category', 'relatedTags', 'otherCategories'));
    }

    public function loadRelated(Request $request, $slug)
    {
        $offset = $request->input('offset', 0);
        $loadedIds = $request->input('loadedIds', []); // get already loaded central_id's
        $limit = 12;
    
        $image = Gallery::where('slug', $slug)->firstOrFail();
    
        $relatedTags = collect(explode(',', $image->tags))
            ->map(fn($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values();
    
        $query = Gallery::where('central_id', '!=', $image->central_id)
            ->where('image_status', 1)
            ->where(function ($q) use ($image, $relatedTags) {
                $q->where('cat_id', $image->cat_id)
                  ->orWhereIn('tags', $relatedTags->toArray());
            });
    
        if (!empty($loadedIds)) {
            $query->whereNotIn('central_id', $loadedIds);
        }
    
        $relatedImages = $query
            ->inRandomOrder()
            ->take($limit)
            ->get();
    
        // Ads
        if (PlatformHelper::isAndroid()) {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=android');
        } else {
            $response = Http::get('https://electricaapps.top/ads/api/ad_api.php?platform=other');
        }
    
        $adInterval = 6;
        if ($response->successful()) {
            $adInterval = $response->json()['wallpaper_number'];
        }
    
        $ads = $this->fetchAdsForCount(count($relatedImages), $adInterval);
    
        $html = view('partials.image_with_ads', [
            'recentImages' => $relatedImages,
            'recentAds' => $ads,
            'adInterval' => $adInterval
        ])->render();
    
        return response()->json([
            'html' => $html,
            'newLoadedIds' => $relatedImages->pluck('central_id')
        ]);
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

    public function download($slug)
    {
        // Fetch the image using the slug and eager load the database relationship
        $image = Gallery::where('slug', $slug)
            ->with('database')  // Eager load the database relationship
            ->firstOrFail();  // This will throw a 404 error if no image is found

        // Increment the download count
        $image->increment('download_count');

        // Get the full external URL to the image
        $imageUrl = $image->database->base_url . 'upload/' . $image->image;

        // Check if the image exists locally or externally
        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            // If it's an external URL, download it
            $response = Http::get($imageUrl);

            if ($response->successful()) {
                // Return the image for download
                return response($response->body())
                    ->header('Content-Type', $response->header('Content-Type'))
                    ->header('Content-Disposition', 'attachment; filename="' . basename($imageUrl) . '"');
            } else {
                // If the request failed, show an error message
                return redirect()->route('image.show', $slug)->with('error', 'Failed to download the image.');
            }
        } else {
            // Fallback to local file system if image is not hosted externally
            $filePath = storage_path('app/public/images/' . $image->image); // Adjust as needed

            if (file_exists($filePath)) {
                return response()->download($filePath);
            }

            // If the file doesn't exist, show an error
            return redirect()->route('image.show', $slug)->with('error', 'File not found.');
        }
    }
}
