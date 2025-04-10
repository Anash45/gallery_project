<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdsController extends Controller
{
    /**
     * Fetch all ads from external API.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllAds()
    {
        $response = Http::get('https://electricaapps.top/ads/api/ad_api.php');

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch ads.',
        ], $response->status());
    }

    /**
     * Fetch ads for a specific package name.
     *
     * @param  string  $package
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdsByPackage($package)
    {
        $response = Http::get('https://electricaapps.top/ads/api/ad_api.php', [
            'cat' => $package,
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'data' => $response->json(),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch ads for the package.',
        ], $response->status());
    }
}
