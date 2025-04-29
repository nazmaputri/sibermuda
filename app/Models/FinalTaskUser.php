<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalTaskUser extends Model
{
    use HasFactory;

    protected $table = 'final_task_user';

    protected $fillable = [
        'final_task_id',
        'course_id',
        'user_id',
        'title',
        'description',
        'photo',
        'certificate_status',
    ];
    
    /**
     * Cast kolom tertentu agar otomatis jadi array, datetime, dll
     */
    protected $casts = [
        'photo' => 'array',
    ];

    /**
     * Relasi ke model FinalTask
     */
    public function finalTask()
    {
        return $this->belongsTo(FinalTask::class);
    }

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
