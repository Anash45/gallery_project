<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    // Define the table
    protected $table = 'tbl_ads';

    // Set the primary key
    protected $primaryKey = 'ad_id';

    // Primary key is not auto-incrementing
    public $incrementing = false;

    // If you’re not using timestamps (created_at, updated_at)
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'ad_id',
        'title',
        'image_path',
        'link',
        'description',
        'db_id',
        'is_active',
    ];

    /**
     * Get the database this ad belongs to.
     */
    public function database()
    {
        return $this->belongsTo(Database::class, 'db_id', 'id');
    }
}
