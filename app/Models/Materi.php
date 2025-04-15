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

=======
>>>>>>> a510269a50966eb25cf1a838a0f878c07d9c3565
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
