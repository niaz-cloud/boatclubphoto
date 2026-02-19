<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Package;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * ✅ Payment → Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * ✅ Payment → Package
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
