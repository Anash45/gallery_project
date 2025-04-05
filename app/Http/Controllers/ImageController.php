<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function show($slug)
    {
        // Fetch the image using the slug and eager load the database relationship
        $image = Gallery::where('slug', $slug)
            ->with('database')  // Eager load the database relationship
            ->firstOrFail();  // This will throw a 404 error if no image is found
        
        $image->increment('view_count');
        
        // Fetch the category manually using the cat_id from the image
        $category = Category::where('source_cid', $image->cat_id)
            ->where('db_id', $image->db_id)
            ->first();
    
        // Return the view with the image and its category
        return view('image.show', compact('image', 'category'));
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
