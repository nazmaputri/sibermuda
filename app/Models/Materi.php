<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'judul', 
        'deskripsi', 
        'course_id',
        'is_preview'
    ];

    public function videos()
    {
        return $this->hasMany(MateriVideo::class);
    }

<<<<<<< HEAD
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
=======
    // public function pdfs()
    // {
    //     return $this->hasMany(MateriPdf::class);
    // }

    // public function youtubes()
    // {
    //     return $this->hasMany(YouTube::class);
    // }

    // public function quizzes()
    // {
    //     return $this->hasMany(Quiz::class);
    // }
>>>>>>> 9229acf410835896412f9dd9fb7287a290e7b1f1

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'materi_user', 'materi_id', 'user_id')
                    ->withPivot('completed_at');
    }

}
