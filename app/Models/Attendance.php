<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'student_id',
        'class_id',
        'status',   // present / absent
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Attendance belongs to a student
     * attendance.student_id -> students.id
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Attendance belongs to a class
     * attendance.class_id -> classes.id
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
