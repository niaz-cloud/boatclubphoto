<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'roll_number',
        'correct_answer',
        'wrong_answer',
        'obtained_mark',
        'total_mark',
        'pass_mark',
        'status',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
