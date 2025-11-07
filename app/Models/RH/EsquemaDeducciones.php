<?php

namespace App\Models\RH;

use App\Models\Empleado;
use App\Models\RH\Deducciones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EsquemaDeducciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_empleado',
        'id_deducciones',
        'tipo',
        'cantidad',
        'id_estatus'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }

    public function deduccion()
    {
        return $this->belongsTo(Deducciones::class, 'id_deducciones', 'id');
    }
}
