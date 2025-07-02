<?php

namespace App\Models\HR;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VacacionesHistorial extends Client
{

    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'concepto',
        'dias',
        'fechas',
        'autorizacion'
    ];
}
