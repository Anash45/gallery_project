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
        Schema::create('tbl_category', function (Blueprint $table) {
            $table->integer('central_cid')->primary();
            $table->integer('source_cid');
            $table->string('category_name', 255)->nullable();
            $table->string('category_image', 255)->nullable();
            $table->tinyInteger('category_status')->nullable();
            $table->integer('db_id')->nullable();
            
            // Add index for the foreign key
            $table->index('db_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_category');
    }
};