<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',      // ✅ CRITICAL FIX
        'roll_number',
        'correct_answer',
        'wrong_answer',
        'obtained_mark',
        'total_mark',
        'pass_mark',
        'status',
    ];

    /**
     * A result belongs to an exam
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    /**
     * A result belongs to a student
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id'); // ✅ FIXED
    }
}
