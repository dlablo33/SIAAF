<?php

namespace App\Models\HR;

use App\Models\Client;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermisoHistorial extends Client
{

    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'periodo',
        'lunes',
        'martes',
        'miercoles',
        'jueves',
        'viernes',
        'total',
        'ajuste_nomina',
        'ajuste_complemento'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function permisoSolicitud(){
        return $this->hasMany(PermisoSolicitud::class);
    }

}
