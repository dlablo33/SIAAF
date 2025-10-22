<?php

namespace App\Models\AdministracionInterna;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticuloPatrimonio extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
        'marca_id',
        'modelo',
        'series',
        'año',
        'dimensiones'
    ];

    // Relaciones
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function articuloResponsable()
    {
        return $this->hasMany(ArticuloResponsable::class);
    }

}
