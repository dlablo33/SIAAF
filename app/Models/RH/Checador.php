<?php

namespace App\Models\RH;

use App\Models\Empleado;
use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checador extends Model
{

    use HasFactory;

    protected $table = 'checador';

    protected $fillable = [
        'id_empleado',
        'date',
        'check_in',
        'check_out'
    ];

    // Relaciones
    public function estatus()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id');
    }

}
