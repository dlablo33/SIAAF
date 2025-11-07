<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'nombre_cliente',
        'correo_cliente',
        'telefono_cliente',
        'tamano_empresa',
        'empleados',
        'servicios',
        'total',
        'recomendacion'
    ];

    protected $casts = [
        'servicios' => 'array',
        'total' => 'decimal:2',
        'empleados' => 'integer'
    ];
}