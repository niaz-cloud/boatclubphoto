<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'auditor_code',
    'phone',
    'email',
    'photo',
    'auditor_details_box',
    'priority',
    'status',
];


}
