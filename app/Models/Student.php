<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // If your table name is "students" (default), this is optional.
    // protected $table = 'students';

    // These fields can be saved/updated using Student::create() / ->update()
    protected $fillable = [
        'roll_number',
        'name',
        'phone',
        'class_id',
        'attendance_count', // keep only if this column exists in your students table
    ];

    /**
     * Relationship: A student belongs to one class.
     * students.class_id -> classes.id
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Relationship: A student can have many attendance records.
     * attendance.student_id -> students.id
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }
}
