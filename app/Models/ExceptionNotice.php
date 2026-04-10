<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExceptionNotice extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'title', 'message', 'resolved'];

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }
}
