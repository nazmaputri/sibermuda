<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalTask extends Model
{
    use HasFactory;

    protected $table = 'final_tasks';

    protected $fillable = [
        'judul',
        'desc',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
