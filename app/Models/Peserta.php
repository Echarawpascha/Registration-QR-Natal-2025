<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Peserta extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'church_origin', 'is_confirmed', 'barcode', 'profile_image'
    ];
    protected $hidden = [
        'password',
    ];
    // Mutator untuk hash password otomatis
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // Relationship with Attendances
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
