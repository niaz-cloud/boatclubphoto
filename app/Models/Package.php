<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Package extends Model
{
    use HasFactory;

    // ✅ Allow mass assignment (optional)
    protected $guarded = [];

    /**
     * ✅ Package → Payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
