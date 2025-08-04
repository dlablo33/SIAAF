<?php

namespace App\Models\AdministracionInterna;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacen extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

}
