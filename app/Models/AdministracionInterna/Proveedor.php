<?php

namespace App\Models\RH;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono'
    ];
}
