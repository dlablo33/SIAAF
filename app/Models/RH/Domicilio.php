<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{

    use HasFactory;

    protected $table = 'cat_domicilio';

    protected $fillable = [
        'calle',
        'numero',
        'numero_int',
        'colonia',
        'codigo_postal',
        'municipio',
        'estado',
        'id_estatus'
    ];

    // Relaciones
    public function estatus()
    {
        return $this->hasMany(Estatus::class);
    }
}
