<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    protected $table = 'blog_tags';
    protected $fillable = ['blog_id', 'tag_id'];
}
