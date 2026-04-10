<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    protected $table = 'staff';

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'photo',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship: A staff manages many clients
    public function clients()
    {
        return $this->hasMany(Client::class, 'assigned_staff_id');
    }
}
