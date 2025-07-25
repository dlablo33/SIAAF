<?php

namespace App\Models\RH;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticuloCompra extends Client
{

    use HasFactory;

    protected $fillable = [
        'tipo_id',
        'nombre',
        'marca_id',
        'stock',
        'medida_id'
    ];

    // Relaciones
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function articuloCompraHistorial()
    {
        return $this->hasMany(ArticuloCompraHistorial::class);
    }
}
