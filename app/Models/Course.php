<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Discount;
use Carbon\Carbon;

class Course extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'price',
        'capacity',
        'chat',
        'start_date',
        'end_date',
        'image_path',
        'mentor_id',
        'status'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(RatingKursus::class, 'course_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'course_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(MateriVideo::class, 'course_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id');
    }

    public function pdfMaterials()
    {
        return $this->hasMany(MateriPdf::class, 'course_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'course_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'course_discount', 'course_id', 'discount_id');
    }

    // Di model Course.php
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'course_id', 'id');
    }

    // Course.php (Model)
    public function getDurationAttribute()
    {
        // Pastikan start_date dan end_date ada
        if ($this->start_date && $this->end_date) {
            $start = \Carbon\Carbon::parse($this->start_date);
            $end = \Carbon\Carbon::parse($this->end_date);
            
            // Menghitung selisih hari
            $diffInDays = $start->diffInDays($end);
            
            // Bisa juga menghitung durasi dalam format minggu atau bulan jika diperlukan
            // $diffInWeeks = $start->diffInWeeks($end);
            // $diffInMonths = $start->diffInMonths($end);
            
            return $diffInDays . ' hari';
        }

        return 'Akses Seumur Hidup';
    }

    public function getIsCompletedForCertificateAttribute()
    {
        $userId = auth()->id();

        return \App\Models\FinalTaskUser::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('certificate_status', 'approved')
            ->exists();
    }

    public function finalTask()
    {
        return $this->hasOne(FinalTask::class, 'course_id');
    }
}

