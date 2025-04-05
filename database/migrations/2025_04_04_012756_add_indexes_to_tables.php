<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add indexes to tbl_databases
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->unique(['host', 'source_db'], 'unique_source');
        });

        // Add indexes to tbl_gallery
        Schema::table('tbl_gallery', function (Blueprint $table) {
            $table->unique(['source_id', 'db_id'], 'unique_gallery');
        });

        // Add indexes to tbl_category
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->unique(['source_cid', 'db_id'], 'unique_category');
        });
    }

    public function down()
    {
        // Remove indexes from tbl_databases
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->dropUnique('unique_source');
        });

        // Remove indexes from tbl_gallery
        Schema::table('tbl_gallery', function (Blueprint $table) {
            $table->dropUnique('unique_gallery');
        });

        // Remove indexes from tbl_category
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->dropUnique('unique_category');
        });
    }
};