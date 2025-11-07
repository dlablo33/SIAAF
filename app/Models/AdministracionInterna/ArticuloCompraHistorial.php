<?php

namespace App\Models\AdministracionInterna;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticuloCompraHistorial extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_id',
        'presentacion',
        'contenido',
        'medida_id',
        'proveedor_id',
        'fecha_compra',
        'precio',
        'precio_unitario',
        'cantidad'
    ];

    // Relaciones
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

}
