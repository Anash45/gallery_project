<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    // Optional if you follow Laravel naming conventions
    protected $table = 'searches';

    // Allow mass assignment on these fields
    protected $fillable = [
        'query', 'count',
    ];

    // Casts (optional but good for safety)
    protected $casts = [
        'count' => 'integer',
    ];
}
