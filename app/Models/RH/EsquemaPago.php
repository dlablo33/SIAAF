<?php

namespace App\Models\HR;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsquemaPago extends Model
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
