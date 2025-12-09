<?php

namespace App\Models\RH;

use App\Models\Empleado;
use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPermiso extends Model
{

    use HasFactory;

    protected $table = 'permiso_solicitud';

    protected $fillable = [
        'id_empleado',
        'id_tipo',
        'razon',
        'fecha',
        'tiempo',
        'observaciones',
        'id_estatus'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }

    public function tipo()
    {
        return $this->belongsTo(PermisoTipo::class, 'id_tipo', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}