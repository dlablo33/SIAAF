<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoTipo extends Model
{

    use HasFactory;

    protected $table = 'cat_permiso_tipo';

    protected $fillable = [
        'nombre',
        'id_estatus'
    ];

    // Relaciones
    public function permisoSolicitud()
    {
        return $this->hasMany(PermisoSolicitud::class, 'id_tipo', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }

}
