<?php

namespace App\Models\HR;

use App\Models\Client;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermisoSolicitud extends Client
{

    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'tipo_id',
        'razon',
        'periodo',
        'fecha',
        'minutos',
        'observaciones',
        'autorizacion',
        'permiso_id',
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function permisoTipo()
    {
        return $this->belongsTo(PermisoTipo::class);
    }

    public function permisoHistorial()
    {
        return $this->belongsTo(PermisoHistorial::class);
    }
}
