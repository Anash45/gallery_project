<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Get the current page, default is 1
        $currentPage = $request->get('page', 1);

        // Get search, category, and tag from the request
        $search = $request->get('search');
        $category = $request->get('category');
        $tag = $request->get('tag');

        try {
            // Set query parameters for WordPress API request
            $queryParams = [
                'per_page' => 3,  // Number of posts per page
                'page' => $currentPage,  // Get the current page
                '_embed' => true,  // Embed author, media, and categories
            ];

            // Add search parameter if provided
            if ($search) {
                $queryParams['search'] = $search;
            }

            // Add category parameter if provided
            if ($category) {
                $queryParams['categories'] = $category;
            }

            // Add tag parameter if provided
            if ($tag) {
                $queryParams['tags'] = $tag;
            }

            // Fetch posts from WordPress API with query parameters
            $response = Http::get('https://www.f4futuretech.com/wp/wp-json/wp/v2/posts', $queryParams);

            // Check if the response is successful
            if ($response->failed()) {
                return redirect('/blog')->with('error', 'Failed to fetch blog posts.');
            }

            // Decode the response to get the blog data
            $blogs = $response->json();

            // Get the total number of pages for pagination
            $totalPages = $response->header('x-wp-totalpages', 1);

            // Fetch categories and tags for the sidebar
            $categories = Http::get('https://www.f4futuretech.com/wp/wp-json/wp/v2/categories')->json();
            $tags = Http::get('https://www.f4futuretech.com/wp/wp-json/wp/v2/tags')->json();

            // Fetch the latest posts for the sidebar
            $latestPosts = Http::get('https://www.f4futuretech.com/wp/wp-json/wp/v2/posts', [
                'per_page' => 3,
                '_embed' => true,
            ])->json();

            // Return the view with blog data and pagination details
            return view('blog.index', compact('blogs', 'totalPages', 'currentPage', 'categories', 'tags', 'latestPosts'));

        } catch (\Exception $e) {
            // Log the error and redirect to the blog page
            \Log::error('Error fetching blog posts: ' . $e->getMessage());
            return redirect('/blog')->with('error', 'An error occurred while fetching the blog posts.');
        }
    }

    public function show($slug)
    {
        try {
            // Fetch the blog post by slug from WordPress API
            $response = Http::get('https://www.f4futuretech.com/wp/wp-json/wp/v2/posts', [
                'slug' => $slug,  // Pass the slug to fetch a specific post
                '_embed' => true,
            ]);

            if ($response->failed()) {
                return redirect('/blog')->with('error', 'Blog post not found.');
            }

            $blog = $response->json();

            // If no blog found, redirect to the blog index page
            if (empty($blog)) {
                return redirect('/blog')->with('error', 'Blog post not found.');
            }

            $blog = $blog[0]; // Get the first (and only) blog post from the response

            return view('blog.details', compact('blog'));
        } catch (\Exception $e) {
            \Log::error('Error fetching blog details: ' . $e->getMessage());
            return redirect('/blog')->with('error', 'An error occurred while fetching the blog details.');
        }
    }
}
