<?php

namespace App\Models\RH;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsquemaPrestaciones extends Model
{

    use HasFactory;

    protected $fillable = [
        'id_empleado',
        'id_prestaciones',
        'tipo',
        'cantidad'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }

    public function prestacion()
    {
        return $this->belongsTo(Prestaciones::class, 'id_prestaciones', 'id');
    }

}
