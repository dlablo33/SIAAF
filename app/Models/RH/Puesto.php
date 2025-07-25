<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{

    use HasFactory;

    protected $table = 'cat_puesto';

    protected $fillable = [
        'nombre',
        'id_departamento',
        'id_estatus'
    ];

    // Relaciones
    public function departamento()
    {
        return $this->hasMany(Department::class);
    }

    public function estatus()
    {
        return $this->hasMany(Estatus::class);
    }
}
