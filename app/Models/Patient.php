<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

    use HasFactory;


    protected $fillable = ['user_id', 'age', 'gender', 'address', 'clinic_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
