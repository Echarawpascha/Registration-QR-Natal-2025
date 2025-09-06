<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Panitia extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'approval_status', 'barcode', 'profile_image'
    ];

    protected $hidden = [
        'password',
    ];

    // Mutator untuk hash password otomatis
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Scope untuk panitia yang approved
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    // Check if panitia is approved
    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    // Relationship with Attendances
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
