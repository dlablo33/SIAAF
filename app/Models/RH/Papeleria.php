<?php

namespace App\Models\HR;

use App\Models\Client;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Papeleria extends Client
{

    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'comprobante_domicilio',
        'ine',
        'nss',
        'curp',
        'constancia',
        'kardex',
        'titulo_ced',
        'acta_nacimiento',
        'cv'
    ];

    // Relaciones
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

}
