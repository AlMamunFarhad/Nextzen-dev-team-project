<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'specialization', 'experience', 'fee', 'bio', 'status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }


    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
