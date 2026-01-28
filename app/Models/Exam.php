<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_question',
        'per_question_mark',
        'negative_mark',
        'total_question_set',
        'total_mark',
        'pass_mark',
    ];

    /**
     * Get the duplicate rolls for the exam.
     */
    public function duplicateRolls()
    {
        return $this->hasMany(DuplicateRoll::class);
    }
}