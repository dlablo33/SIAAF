<?php

namespace App\Models\HR;

use App\Models\Client;
use App\Models\Empleado;
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

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
