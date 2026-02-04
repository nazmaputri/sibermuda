<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'image_path',
        'category',
        'published_at',
        'author',
        'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title')) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_at->format('d M Y');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
