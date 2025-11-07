<?php

namespace App\Models\RH;

use App\Models\Empleado;
use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'prestamo';

    protected $fillable = [
        'nombre',
        'id_empleado',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'pago_periodo',
        'id_estatus'
    ];

    // Relaciones
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }
}