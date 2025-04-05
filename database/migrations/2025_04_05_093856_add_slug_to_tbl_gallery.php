<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_gallery', function (Blueprint $table) {
            $table->string('slug', 255)->after('image_name')->nullable();
        });

        // Generate slugs using raw SQL to avoid Eloquent timestamp issues
        $items = DB::table('tbl_gallery')->get();
        
        foreach ($items as $item) {
            $slug = Str::slug($item->image_name);
            
            // Check for uniqueness and append number if needed
            $count = DB::table('tbl_gallery')
                     ->where('slug', 'like', "$slug%")
                     ->count();
            
            $finalSlug = $count > 0 ? "$slug-$count" : $slug;
            
            DB::table('tbl_gallery')
              ->where('central_id', $item->central_id)
              ->update(['slug' => $finalSlug]);
        }

        // Add the index after all slugs are populated
        Schema::table('tbl_gallery', function (Blueprint $table) {
            $table->unique('slug', 'gallery_slug_unique');
        });
    }

    public function down()
    {
        Schema::table('tbl_gallery', function (Blueprint $table) {
            $table->dropUnique('gallery_slug_unique');
            $table->dropColumn('slug');
        });
    }
};