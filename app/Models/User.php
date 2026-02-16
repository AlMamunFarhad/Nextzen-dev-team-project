<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // User model role constants

    public const ROLE_ADMIN = 0;
    public const ROLE_DOCTOR = 1;
    public const ROLE_PATIENT = 2;
    public const ROLE_RECEPTIONIST = 3;

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }
    public function isReceptionist()
    {
        return $this->role == self::ROLE_RECEPTIONIST;
    }
    public function isDoctor()
    {
        return $this->role == self::ROLE_DOCTOR;
    }
    public function isPatient()
    {
        return $this->role == self::ROLE_DOCTOR;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
