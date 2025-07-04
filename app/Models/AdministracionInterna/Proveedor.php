<?php

namespace App\Models\HR;

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
