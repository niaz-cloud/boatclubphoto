<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;   // ✅ ADD THIS LINE

class OmrError extends Model
{
    protected $fillable = [
        'exam_id',
        'file_path',
        'roll_number',
        'set_number',
        'message',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
