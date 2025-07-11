<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'excerpt', 'body', 'image_path', 'slug', 'is_published', 'additional_info', 'category_id', 'read_time', 'change_user_id', 'changelog'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function changeUser()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'DESC');
    }

    public function historypost()
    {
        return $this->hasMany(HistoryPost::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Many-to-many relationship for users who highlighted this post
    public function highlightedByUsers()
    {
        return $this->belongsToMany(User::class, 'highlight_posts', 'post_id', 'user_id');
    }

    // Existing relationship for direct access to highlight_post records
    public function highlightPosts()
    {
        return $this->hasMany(HighlightPost::class);
    }

    public function getIsHighlightedAttribute()
    {
        // If the property is set (from select), use it
        if (array_key_exists('is_highlighted', $this->attributes)) {
            return (bool) $this->attributes['is_highlighted'];
        }
        // Otherwise, check the relationship
        return $this->highlightPosts()->exists();
    }
}
