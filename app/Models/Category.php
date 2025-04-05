<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_category';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'central_cid';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'central_cid',
        'source_cid',
        'category_name',
        'category_image',
        'category_status',
        'db_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'central_cid' => 'integer',
        'source_cid' => 'integer',
        'category_status' => 'integer',
        'db_id' => 'integer',
    ];

    /**
     * Get the route key for the model.
     * (This makes Laravel use 'slug' for route model binding)
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope to find by slug
     */
    public function scopeWhereSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    /**
     * Get the database associated with this category.
     */
    public function database()
    {
        return $this->belongsTo(Database::class, 'db_id', 'id');
    }

    /**
     * Get all gallery items for this category.
     */
    public function galleryItems()
    {
        return $this->hasMany(Gallery::class, 'cat_id', 'source_cid')
                    ->where('db_id', $this->db_id);  // Adding the db_id condition
    }
}