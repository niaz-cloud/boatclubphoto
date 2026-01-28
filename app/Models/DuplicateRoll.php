<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateRoll extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'roll_number'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
