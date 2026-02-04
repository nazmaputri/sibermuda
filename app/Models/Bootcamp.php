<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bootcamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration',
        'level',
        'schedule',
        'price',
        'discount_price',
        'image',
        'features',
        'syllabus',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'syllabus' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bootcamp) {
            if (empty($bootcamp->slug)) {
                $bootcamp->slug = Str::slug($bootcamp->title);
            }
        });

        static::updating(function ($bootcamp) {
            if ($bootcamp->isDirty('title')) {
                $bootcamp->slug = Str::slug($bootcamp->title);
            }
        });
    }
}
