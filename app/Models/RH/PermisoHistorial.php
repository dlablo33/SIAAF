<?php

namespace App\Models\RH;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoHistorial extends Model
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
