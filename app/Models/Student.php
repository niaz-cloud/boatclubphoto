<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'roll_number',
        'name',
        'phone',
        'class_id',
        'teacher_id',          // ✅ ADDED
        'attendance_count'
    ];

    /**
     * A student belongs to one class
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * ✅ Student belongs to a teacher (User model)
     * students.teacher_id → users.id
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function students()
    {
        return $this->hasMany(\App\Models\Student::class, 'teacher_id');
    }
    /**
     * Student has many attendance records
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    /**
     * Student has many results
     */
    public function results()
    {
        return $this->hasMany(Result::class, 'roll_number', 'roll_number');
    }

    /**
     * Student has many payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Student has many subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(StudentSubscription::class);
    }

    /**
     * Student has one active subscription
     */
    public function activeSubscription()
    {
        return $this->hasOne(StudentSubscription::class)
            ->where('status', 'active');
    }

    /**
     * Student belongs to a user (for login)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
