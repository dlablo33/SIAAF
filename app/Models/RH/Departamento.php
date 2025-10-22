<?php

namespace App\Models\RH;

use App\Models\Estatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{

    use HasFactory;

    protected $table = 'cat_departamento';

    protected $fillable = [
        'nombre',
        'id_area',
        'id_estatus'
    ];

    // Relaciones
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id');
    }
}
