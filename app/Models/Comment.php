<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that made the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the users that saved this comment.
     */
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_comments')->withTimestamps();
    }

    /**
     * Check if the comment is saved by the given user.
     */
    public function isSavedBy(User $user)
    {
        return $this->savedByUsers->contains($user);
    }
}
