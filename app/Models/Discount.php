<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Carbon\Carbon;

class Discount extends Model {

    use HasFactory;

    protected $fillable = [
        'coupon_code',
        'discount_percentage',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'apply_to_all'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_discount', 'discount_id', 'course_id');
    }

}


