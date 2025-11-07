<?php

namespace App\Models\AdministracionInterna;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticuloCompraControl extends Client
{

    use HasFactory;

    protected $fillable = [
        'articulo_compra_id',
        'cantidad',
        'medida_id',
    ];

    // Relaciones
    public function articuloCompra()
    {
        return $this->belongsTo(ArticuloCompra::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

}
