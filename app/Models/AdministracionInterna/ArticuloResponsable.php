<?php

namespace App\Models\HR;

use App\Models\Client;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticuloResponsable extends Client
{

    use HasFactory;

    protected $primaryKey   = 'codigo';

    protected $fillable = [
        'articulo_patrimonio_id',
        'tipo_id',
        'department_id',
        'almacen_id',
        'fecha_asignacion',
        'color',
        'año'
    ];

    // Relaciones
    public function articulo_patrimonio()
    {
        return $this->belongsTo(ArticuloPatrimonio::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

}
