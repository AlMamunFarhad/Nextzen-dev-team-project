<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;


    protected $fillable = ['doctor_id', 'patient_id', 'slot_id', 'appointment_date', 'status', 'notes'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function slot()
    {
        return $this->belongsTo(TimeSlot::class, 'slot_id');
    }
}
