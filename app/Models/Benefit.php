<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;
    protected $fillable = [
        'benefit_amount',
        'description',
        'remarks', // Nullable
    ];

    public function enquiry()
    {
        return $this->morphOne(Enquiry::class, 'enquirable');
    }
}