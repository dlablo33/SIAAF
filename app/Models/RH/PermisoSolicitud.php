<?php

namespace App\Models\RH;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoSolicitud extends Model
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
