<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        "title",
        "description",
        "banner_image",
        "user_id",
        "status",
        "facebook_post_id",
        "category_id",
        "view_time",
    ];

    protected $withCount = ['favoritedByUsers']; // Tự động đếm số lượt thích

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favoritedByUsers()->where('user_id', $user->id)->exists();
    }

    public function favoritesCount()
    {
        return $this->favorited_by_users_count;
    }

    public function scopePublic($query)
    {
        return $query->where('status', 'public');
    }

    public static function countAllBlogs()
    {
        return self::count();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getViewTimeByCategory()
    {
        return self::select('category_id')
            ->selectRaw('SUM(view_time) as total_view_time')
            ->groupBy('category_id')
            ->with('category')
            ->get();
    }
    
    // Tìm các blog có view_time cao nhất
    public static function getTopViewTimeBlogs($limit = 10)
    {
        return self::orderBy('view_time', 'desc')
            ->limit($limit)
            ->get();
    }
}
