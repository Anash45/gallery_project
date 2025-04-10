<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->string('packageName')->nullable()->after('source_db');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->dropColumn('packageName');
        });
    }
};

