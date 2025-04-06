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
        Schema::create('tbl_ads', function (Blueprint $table) {
            $table->integer('ad_id')->primary(); // Custom primary key
            $table->string('title', 255);
            $table->string('image_path', 255); // Local or external image
            $table->string('link', 255);
            $table->text('description')->nullable();
            $table->integer('db_id')->nullable(); // FK to tbl_databases
            $table->tinyInteger('is_active')->default(1);

            // Index for db_id
            $table->index('db_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_ads');
    }
};
