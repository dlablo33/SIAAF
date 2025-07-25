<?php

namespace App\Models\RH;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medida extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre',
    ];


}
