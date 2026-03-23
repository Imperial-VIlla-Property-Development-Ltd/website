<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLocation extends Model
{
    protected $fillable = [
        'client_id','user_id','lat','lng','ip','user_agent','recorded_at'
    ];

    protected $dates = ['recorded_at','created_at','updated_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
