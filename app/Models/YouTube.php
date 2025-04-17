<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YouTube extends Model
{
    use HasFactory;

    protected $table = 'youtube';

    protected $fillable = [
        'title',
        'materi_id',
        'description',
        'link',
    ];

    // Relasi ke model Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    // Relasi ke model Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
