<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientNote extends Model
{
    protected $fillable = ['clinic_id', 'patient_id', 'author_id', 'note', 'follow_up_date'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
