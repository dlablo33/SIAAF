<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudVacaciones extends Model
{
    use HasFactory;

    protected $table = 'vacaciones_solicitud';

    protected $fillable = [
        'id_empleado_vacaciones',
        'concepto',
        'fecha_inicio',
        'fecha_final',
        'prima',
        'observaciones',
        'id_estatus'
    ];

    // Relaciones
    public function empleadoVacaciones()
    {
        return $this->belongsTo(EmpleadoVacaciones::class, 'id_empleado_vacaciones', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}
