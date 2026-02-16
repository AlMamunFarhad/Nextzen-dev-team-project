<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\PatientNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo',
        'primary_color',
        'secondary_color',
        'phone',
        'address'
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function notes()
    {
        return $this->hasMany(PatientNote::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
