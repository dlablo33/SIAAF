<?php

namespace App\Models\RH;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papeleria extends Model
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
