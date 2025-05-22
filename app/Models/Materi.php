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

    public function youtube()
    {
        return $this->hasMany(YouTube::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'materi_user', 'materi_id', 'user_id')
                    ->withPivot('completed_at');
    }

    public function userProgresses()
    {
        return $this->hasMany(UserMateriProgress::class);
    }

}
