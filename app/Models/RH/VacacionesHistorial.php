<?php

namespace App\Models\RH;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionesHistorial extends Model
{

    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'concepto',
        'dias',
        'fechas',
        'autorizacion'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
