<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'section',
        'class_code',
        'academic_year',
        'description',
        'status',
        'created_by',
    ];

    /**
     * Relationship: A class has many students
     * classes.id -> students.class_id
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Relationship: A class has many attendance records
     * classes.id -> attendance.class_id
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }
}
