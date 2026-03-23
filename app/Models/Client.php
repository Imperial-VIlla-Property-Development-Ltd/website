<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'firstname',
    'middlename',
    'lastname',
    'phone_number',
    'address',
    'email',
    'account_number',
    'stage',
    'nin',
    'pfa_selected',
    'pfa_uploaded_path',
    'registration_id',
    'assigned_staff_id', // ✅ ADD THIS
    'rejection_reason',
];

protected $casts = [
        'rejection_reason' => 'string',
    ];

    public function user() { return $this->belongsTo(\App\Models\User::class,'user_id'); }
//public function staff() { return $this->belongsTo(\App\Models\User::class,'staff_id'); }
public function documents() { return $this->hasMany(Document::class,'client_id'); }
public function staff()
{
    return $this->belongsTo(User::class, 'assigned_staff_id');
}

}
