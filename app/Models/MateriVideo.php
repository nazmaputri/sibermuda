<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriVideo extends Model
{
    use HasFactory;

    protected $table = 'materi_video'; 

    protected $fillable = [
        'title',
        'materi_id',
        'description',
        'link'
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
