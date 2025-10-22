<?php

namespace App\Models\AdministracionInterna;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
        'placa',
        'niv',
        'marca_id',
        'modelo',
        'año',
        'color',
        'tipo'

    ];

    // Relaciones
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

}
