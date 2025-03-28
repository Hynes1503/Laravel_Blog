<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'status'];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
