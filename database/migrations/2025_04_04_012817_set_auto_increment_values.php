<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE tbl_category MODIFY central_cid INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132');
        DB::statement('ALTER TABLE tbl_databases MODIFY id INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5');
        DB::statement('ALTER TABLE tbl_gallery MODIFY central_id INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=585');
    }

    public function down()
    {
        // Note: There's no direct way to "undo" auto_increment changes
        // You would need to know the previous values to revert
        DB::statement('ALTER TABLE tbl_category MODIFY central_cid INT NOT NULL');
        DB::statement('ALTER TABLE tbl_databases MODIFY id INT NOT NULL');
        DB::statement('ALTER TABLE tbl_gallery MODIFY central_id INT NOT NULL');
    }
};