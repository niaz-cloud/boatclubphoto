<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;

class CorrectAnswer extends Model
{
    protected $fillable = [
        'exam_id',
        'set_number',
        'question_number',
        'student_option',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
