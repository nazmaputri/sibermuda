<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMateriProgress extends Model
{
    use HasFactory;

    protected $table = 'user_materi_progress';

    protected $fillable = [
        'user_id',
        'materi_id',
        'course_id',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Materi
    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}
