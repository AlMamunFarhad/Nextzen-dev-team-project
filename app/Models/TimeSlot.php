<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{

    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'slot_time',
        'is_booked',
    ];

    protected $casts = [
        'is_booked' => 'boolean',
    ];

    public function schedule()
    {
        return $this->belongsTo(DoctorSchedule::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'slot_id');
    }

    // public function slots()
    // {
    //     return $this->hasMany(TimeSlot::class);
    // }
}
