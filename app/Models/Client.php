<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'assigned_staff_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }
 public function documents()
{
    return $this->hasMany(Document::class);
}

}
