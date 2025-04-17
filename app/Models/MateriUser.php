<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriUser extends Model
{
    use HasFactory;

    protected $table = 'materi_user';

    protected $fillable = [
        'nilai',
        'user_id', 
        'courses_id',
        'quiz_id', 
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}

