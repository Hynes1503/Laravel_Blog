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
        "status"
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
}
