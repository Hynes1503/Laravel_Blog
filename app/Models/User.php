<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
/**implements MustVerifyEmail**/
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'facebook_id',
        'facebook_access_token',
        'reported',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'reported' => 'boolean',
        ];
    }

    public function favorites()
    {
        return $this->belongsToMany(Blog::class, 'favorites')->withTimestamps();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function hasPurchased($blog)
    {
        return $this->purchases()->where('blog_id', $blog->id)->where('is_paid', true)->exists();
    }

    public function publicBlogsCount()
    {
        return $this->hasMany(Blog::class)->where('status', 'public')->count();
    }
    public function BlogsCount()
    {
        return $this->hasMany(Blog::class)->count();
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }
}
