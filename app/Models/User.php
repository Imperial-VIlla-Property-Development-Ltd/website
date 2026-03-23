<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name','email','password','role','staff_id','pension_number','profile_photo','is_active', 'otp_code','otp_expires_at','otp_attempts',
    ];
    // cast otp_expires_at to datetime and otp_code as string
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'otp_code' => 'string',
        'is_active' => 'boolean',
    ];

    protected $hidden = ['password','remember_token'];

    // relationship to client profile
    public function clients() { return $this->hasMany(Client::class,'staff_id'); }


    public function isRole($role)
    {
        return $this->role === $role;
    }

    // convenience creation for pension numbers
    public static function generatePensionNumber()
    {
        return 'PEN'.strtoupper(Str::random(12));
    }
public function client()
{
    return $this->hasOne(\App\Models\Client::class, 'user_id');
}

public function assignedClients()
{
    return $this->hasMany(Client::class, 'assigned_staff_id');
}

  

}
