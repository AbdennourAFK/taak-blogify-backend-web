<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'published_at',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users who liked this post.
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    /**
     * Get the comments for this post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Get the number of likes for this post.
     */
    public function getLikesCountAttribute(): int
    {
        // If likes_count is already loaded via withCount, use it
        if (isset($this->attributes['likes_count'])) {
            return (int) $this->attributes['likes_count'];
        }
        
        // Otherwise, count the relationship
        return $this->likes()->count();
    }

    /**
     * Check if a user has liked this post.
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // If likes are already loaded, check the collection
        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('id', $user->id);
        }

        // Otherwise, query the database
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the post is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at <= now();
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Generate a unique slug from the title.
     */
    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Retrieve the model for route model binding.
     * Uses slug instead of the default key (id).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
