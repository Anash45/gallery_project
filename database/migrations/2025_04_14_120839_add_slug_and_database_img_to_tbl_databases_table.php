<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('database_name');
            $table->string('database_img')->nullable()->after('slug');
        });

        // Populate slug values uniquely for existing records
        $databases = DB::table('tbl_databases')->get();

        foreach ($databases as $db) {
            $baseSlug = Str::slug($db->database_name);
            $slug = $baseSlug;
            $i = 1;

            // Ensure uniqueness
            while (DB::table('tbl_databases')->where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            DB::table('tbl_databases')->where('id', $db->id)->update(['slug' => $slug]);
        }

        // Now make slug non-nullable
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_databases', function (Blueprint $table) {
            $table->dropColumn(['slug', 'database_img']);
        });
    }
};
