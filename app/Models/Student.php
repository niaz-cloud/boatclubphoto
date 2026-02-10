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
    'user_id',          // 🔥 THIS WAS MISSING
    'roll_number',
    'name',
    'phone',
    'class_id',
    'attendance_count'
];

    /**
     * A student belongs to one class
     * students.class_id → classes.id
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * A student can have many attendance records
     * attendance.student_id → students.id
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    /**
     * ✅ A student can have many results
     * results.student_id → students.id
     */
    public function results()
{
    return $this->hasMany(
        Result::class,
        'roll_number',     // FK on results table
        'roll_number'      // PK on students table
    );
}
}
