<?php

namespace App\Models\HR;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

}
