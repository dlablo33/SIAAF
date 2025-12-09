<?php

namespace App\Models\RH;

use App\Models\Empleado;
use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoVacaciones extends Model
{
    use HasFactory;

    protected $table = 'empleado_vacaciones';

    protected $fillable = [
        'id_empleado',
        'ano',
        'vacaciones_disponibles',
        'vacaciones_restantes',
        'id_estatus'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}
