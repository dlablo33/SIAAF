<?php

namespace App\Models\HR;

use App\Models\Client;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EsquemaPago extends Client
{

    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'tipo',
        'sueldo',
        'bono_puntualidad',
        'bono_asistencia',
        'despensa',
        'septimo_dia',
        'total_semana',
        'mensual_anticipado'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

}
