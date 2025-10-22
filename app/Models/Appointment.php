<?php

// app/Models/Appointment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'empleado_id', 'date_time', 'service_type', 'price', 'status', 'notes'
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
