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
        // Modify the ad_id column to be auto-incrementing
        Schema::table('tbl_ads', function (Blueprint $table) {
            $table->increments('ad_id')->change();  // Make ad_id auto-increment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the ad_id column back to a regular integer without auto-increment
        Schema::table('tbl_ads', function (Blueprint $table) {
            $table->integer('ad_id')->change();  // Remove auto-increment
        });
    }
};
