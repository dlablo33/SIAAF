<?php

namespace App\Models\HR;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermisoTipo extends Client
{

    use HasFactory;

    protected $fillable = [
        'nombre_id',
    ];

    // Relaciones
    public function permisoSolicitud()
    {
        return $this->hasMany(PermisoSolicitud::class);
    }

}
