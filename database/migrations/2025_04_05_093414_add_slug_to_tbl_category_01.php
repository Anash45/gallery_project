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
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->string('slug', 255)->after('category_name')->nullable();
        });

        // Generate slugs using raw SQL to avoid Eloquent timestamp issues
        $categories = DB::table('tbl_category')->get();
        
        foreach ($categories as $category) {
            $slug = Str::slug($category->category_name);
            
            // Check for uniqueness and append number if needed
            $count = DB::table('tbl_category')
                     ->where('slug', 'like', "$slug%")
                     ->count();
            
            $finalSlug = $count > 0 ? "$slug-$count" : $slug;
            
            DB::table('tbl_category')
              ->where('central_cid', $category->central_cid)
              ->update(['slug' => $finalSlug]);
        }

        // Add the index after all slugs are populated
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->unique('slug', 'category_slug_unique');
        });
    }

    public function down()
    {
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->dropUnique('category_slug_unique');
            $table->dropColumn('slug');
        });
    }
};