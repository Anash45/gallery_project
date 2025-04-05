<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_gallery', function (Blueprint $table) {
            $table->integer('central_id')->primary();
            $table->integer('source_id');
            $table->integer('cat_id');
            $table->string('image', 500);
            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);
            $table->text('image_url');
            $table->string('type', 45)->default('upload');
            $table->string('featured', 10)->default('no');
            $table->text('tags');
            $table->string('image_name', 255);
            $table->string('image_resolution', 255)->default('0');
            $table->string('image_size', 255)->default('0');
            $table->string('image_extension', 45);
            $table->integer('image_status')->default(1);
            $table->string('image_thumb', 500);
            $table->timestamp('last_update')->useCurrent();
            $table->integer('rewarded')->default(0);
            $table->string('s_uploaded', 255)->default('0');
            $table->text('description');
            $table->integer('db_id');
            
            // Add indexes if needed
            $table->index('cat_id');
            $table->index('db_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_gallery');
    }
};