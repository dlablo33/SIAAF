<?php

namespace App\Models\RH;

use App\Models\Empleado;
use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoSolicitud extends Model
{

    use HasFactory;

    protected $fillable = [
        'id_empleado',
        'id_tipo',
        'razon',
        'periodo',
        'fecha',
        'minutos',
        'observaciones',
        'autorizacion',
        'id_estatus',
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }

    public function permisoTipo()
    {
        return $this->belongsTo(PermisoTipo::class, 'id_tipo', 'id');
    }

    public function permisoHistorial()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}
