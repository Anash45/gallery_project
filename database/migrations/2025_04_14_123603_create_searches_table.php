<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->string('query')->unique(); // Unique search text
            $table->unsignedInteger('count')->default(1); // How many times it's searched
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searches');
    }
};
