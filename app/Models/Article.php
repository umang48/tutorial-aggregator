<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;
    // 1. Allow these columns to be saved in bulk
    protected $fillable = [
        'devto_id', 'title', 'url', 'description', 
        'tags', 'public_reactions_count', 'published_at'
    ];

    // 2. Automatically cast the JSON tags column into a PHP Array
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
        ];
    }

    // Tell Scout which data should be indexed for searching
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'tags' => implode(', ', $this->tags ?? []),
        ];
    }
}
