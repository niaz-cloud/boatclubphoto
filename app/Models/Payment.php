<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'package_id',
        'amount',
        'status',
        'payment_date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Payment → Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Payment → Package
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
