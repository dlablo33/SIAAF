<?php

namespace App\Models\RH;

use App\Models\RH\Departamento;
use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{

    use HasFactory;

    protected $table = 'cat_puestos';

    protected $fillable = [
        'nombre',
        'id_departamento',
        'id_estatus'
    ];

    // Relaciones
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}
