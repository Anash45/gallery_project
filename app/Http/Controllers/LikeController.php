<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LikeController extends Controller
{
    public function toggleLike(Request $request)
    {
        // Get the slug from the request
        $slug = $request->input('slug');
        
        // Get current liked images from the cookie (an array)
        $liked = json_decode($request->cookie('liked_images', '[]'), true);
    
        // Toggle like/unlike
        if (!in_array($slug, $liked)) {
            // Add to the liked list
            $liked[] = $slug;
        } else {
            // Remove from the liked list (unlike)
            $liked = array_values(array_filter($liked, fn($s) => $s !== $slug));
        }
    
        // Update the cookie with the new liked images array
        $cookie = cookie('liked_images', json_encode($liked), 60 * 24 * 365); // Expiry in 1 year
    
        // Return the updated liked state in the response (JSON)
        return response()->json([
            'liked' => in_array($slug, $liked)
        ])->withCookie($cookie);
    }
    
}
