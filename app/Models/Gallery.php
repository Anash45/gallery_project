<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Gallery extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_gallery';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'central_id';

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
        'central_id',
        'source_id',
        'cat_id',
        'image',
        'view_count',
        'download_count',
        'image_url',
        'type',
        'featured',
        'tags',
        'image_name',
        'slug',
        'image_resolution',
        'image_size',
        'image_extension',
        'image_status',
        'image_thumb',
        'last_update',
        'rewarded',
        's_uploaded',
        'description',
        'db_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'central_id' => 'integer',
        'source_id' => 'integer',
        'cat_id' => 'integer',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'image_status' => 'integer',
        'rewarded' => 'integer',
        'db_id' => 'integer',
        'last_update' => 'datetime',
    ];

    /**
     * Get the route key for the model.
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
     * Get the database associated with this gallery item.
     */
    public function database()
    {
        return $this->belongsTo(Database::class, 'db_id', 'id');
    }
    // Add this method to your Gallery model
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'central_cid');
    }
}