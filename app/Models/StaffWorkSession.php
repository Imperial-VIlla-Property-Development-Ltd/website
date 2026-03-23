<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffWorkSession extends Model
{
    protected $fillable = [
        'staff_id', 'work_date', 'start_time', 'end_time', 'hours_spent'
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
