<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
     protected $fillable = [
        'name',
        'address',
        'phone',
        'email'
    ];

    // Doctors 
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
