<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'photo',
        'email',
        'password',      
        'phone_number',
        'role',          
        'experience',  
        'status', 
        'email_verified_at',     
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function managedCourses()
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function materiUsers()
    {
        return $this->belongsToMany(Materi::class, 'materi_user', 'user_id', 'materi_id')
                    ->withTimestamps(); // Memastikan timestamp juga disimpan jika ada
    }

    public function finalTaskUser()
    {
        return $this->hasMany(FinalTaskUser::class);
    }
  
}
