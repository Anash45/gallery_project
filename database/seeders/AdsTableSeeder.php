<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_ads')->insert([
            [
                'title' => '50% Off on All Images',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Get 50% off on all images this weekend only!',
                'db_id' => 4, // For Cats
            ],
            [
                'title' => 'About Butterflies',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Learn more about the amazing world of butterflies.',
                'db_id' => 3, // For Butterflies
            ],
            [
                'title' => 'Top Trending Collections',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Browse our top trending image collections.',
                'db_id' => 4, // For Cats
            ],
            [
                'title' => 'Explore Butterfly Facts',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Explore amazing butterfly facts and pictures.',
                'db_id' => 3, // For Butterflies
            ],
            [
                'title' => 'Discover More Cats',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Discover new breeds of cats and their behaviors.',
                'db_id' => 4, // For Cats
            ],
            [
                'title' => 'Join the Butterfly Community',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Join a community of butterfly enthusiasts.',
                'db_id' => 3, // For Butterflies
            ],
            [
                'title' => 'Cat Care Tips and Tricks',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Learn the best tips and tricks for caring for cats.',
                'db_id' => 4, // For Cats
            ],
            [
                'title' => 'Explore Butterfly Conservation',
                'image_path' => 'https://placehold.co/400x700',
                'link' => 'https://example.com/',
                'description' => 'Support butterfly conservation efforts around the world.',
                'db_id' => 3, // For Butterflies
            ],
        ]);
    }
}
