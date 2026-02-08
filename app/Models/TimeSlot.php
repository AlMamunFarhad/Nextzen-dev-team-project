<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
use HasFactory;


protected $fillable = ['schedule_id','slot_time','is_booked'];


public function schedule()
{
return $this->belongsTo(DoctorSchedule::class, 'schedule_id');
}


public function appointment()
{
return $this->hasOne(Appointment::class, 'slot_id');
}
}
