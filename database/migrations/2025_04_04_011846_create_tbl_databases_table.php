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
        Schema::create('tbl_databases', function (Blueprint $table) {
            $table->integer('id')->primary(); // Changed from increments() to integer()
            $table->string('database_name', 255);
            $table->string('base_url', 255);
            $table->string('host', 255);
            $table->string('source_db', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_databases');
    }
};