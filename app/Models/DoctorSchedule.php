<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;


protected $fillable = ['doctor_id','day','start_time','end_time','slot_duration'];


public function doctor()
{
return $this->belongsTo(Doctor::class);
}


public function slots()
{
return $this->hasMany(TimeSlot::class, 'schedule_id');
}
}
